<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
class AuditController extends BaseController
{
    /**
     * @var string the default layout for the views
     */
    public $layout = '//layouts/main';

    public $items_per_page = 100;

    public function accessRules()
    {
        return array(
            array('allow',
                'roles' => array('TaskViewAudit'),
            ),
        );
    }

    public function beforeAction($action)
    {
        Yii::app()->assetManager->registerScriptFile('js/audit.js');
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->pageTitle = 'Audit';
        $this->render('index');
    }

    public function actionSearch()
    {
        if (isset($_POST['page'])) {
            $data = $this->getData($_POST['page']);
        } else {
            $data = $this->getData();
        }


        $this->renderPartial('_list', array('data' => $data), false, true);
        echo '<!-------------------------->';
        $this->renderPartial('_pagination', array('data' => $data), false, true);
    }

    public function criteria($count = false)
    {
        $criteria = new CDbCriteria();
        $request = \Yii::app()->getRequest();
        $user_name = $request->getParam('oe-autocompletesearch');
        $site_id = $request->getParam('site_id');
        $firm_id = $request->getParam('firm_id');
        $action = $request->getParam('action');
        $target_type = $request->getParam('target_type');
        $event_type_id = $request->getParam('event_type_id');
        $date_from = $request->getParam('date_from');
        $date_to = $request->getParam('date_to');
        $hos_num = $request->getParam('hos_num');

        if ($count) {
            $criteria->select = 'count(*) as count';
        }

        if ($site_id) {
            $criteria->addCondition('site_id = :site_id');
            $criteria->params[':site_id'] = $site_id;
        }

        if ($firm_id) {
            $firm = Firm::model()->findByPk($firm_id);
            $firm_ids = array();
            foreach (Firm::model()->findAll('name=?', array($firm->name)) as $firm) {
                $firm_ids[] = $firm->id;
            }
            if (!empty($firm_ids)) {
                $criteria->addInCondition('t.firm_id', $firm_ids);
            }
        }

        if ($user_name) {
            $user_ids = array();

            $criteria2 = new CDbCriteria();
            $criteria2->addCondition(array('active = :active'));
            $criteria2->addCondition(array("LOWER(concat_ws(' ',first_name,last_name)) = :term"));

            $params[':active'] = 1;
            $params[':term'] = strtolower($user_name);

            $criteria2->params = $params;

            foreach (User::model()->findAll($criteria2) as $user) {
                $user_ids[] = $user->id;
            }

            $criteria->addInCondition('user_id', $user_ids);
        }

        if ($action) {
            $criteria->addCondition('action_id=:action_id');
            $criteria->params[':action_id'] = $action;
        }

        if ($target_type) {
            $criteria->addCondition('type_id=:type_id');
            $criteria->params[':type_id'] = $target_type;
        }

        if ($event_type_id) {
            $criteria->addCondition('event.event_type_id=:event_type_id');
            $criteria->params[':event_type_id'] = $event_type_id;
        }

        if ($date_from) {
            $date_from = Helper::convertNHS2MySQL($date_from).' 00:00:00';
            $criteria->addCondition('`t`.created_date >= :date_from');
            $criteria->params[':date_from'] = $date_from;
        }

        if ($date_to) {
            $date_to_SQL = Helper::convertNHS2MySQL($date_to).' 23:59:59';
            $criteria->addCondition('`t`.created_date <= :date_to');
            $criteria->params[':date_to'] = $date_to_SQL;
        }

        if ($hos_num) {
            if ($patient = Patient::model()->find('hos_num=?', array($hos_num))) {
                $criteria->addCondition('patient_id='.$patient->id);
            } else {
                if ($patient = Patient::model()->find('hos_num=?', array(str_pad($hos_num, 7, '0', STR_PAD_LEFT)))) {
                    $criteria->addCondition('patient_id='.$patient->id);
                } else {
                    $criteria->addCondition('patient_id=0');
                }
            }
        }

        !($count) && $criteria->join = 'left join event on t.event_id = event.id left join event_type on event.event_type_id = event_type.id';

        return $criteria;
    }

    public function getData($page = 1, $id = false)
    {
        $data = array();

        if ($_data = Audit::model()->with('event')->find($this->criteria(true))) {
            $data['total_items'] = $_data->count;
        } else {
            $data['total_items'] = 0;
        }

        $criteria = $this->criteria();

        $criteria->order = 't.id desc';
        $criteria->limit = $this->items_per_page;
        if ($id) {
            $criteria->addCondition('t.id > '.(integer) $id);
        } else {
            $criteria->offset = (($page - 1) * $this->items_per_page);
        }

        $data['items'] = Audit::model()->findAll($criteria);
        $data['pages'] = ceil($data['total_items'] / $this->items_per_page);
        if ($data['pages'] < 1) {
            $data['pages'] = 1;
        }
        if ($page > $data['pages']) {
            $page = $data['pages'];
        }
        if (!$id) {
            $data['page'] = $page;
        }

        return $data;
    }

    public function actionUpdateList()
    {
        if (!$audit = Audit::model()->findByPk(@$_GET['last_id'])) {
            echo "";
            \OELog::log('Log entry not found: '.@$_GET['last_id']);
            return;
        }

        $this->renderPartial('_list_update', array('data' => $this->getData(null, $audit->id)), false, true);
    }

    public function actionUsers()
    {
        $users = array();

        $criteria = new CDbCriteria();

        $criteria->addCondition(array('active = :active'));
        $criteria->addCondition(array("LOWER(concat_ws(' ',first_name,last_name)) LIKE :term"));

        $params[':active'] = 1;
        $params[':term'] = '%'.strtolower(strtr($_GET['term'], array('%' => '\%'))).'%';

        $criteria->params = $params;
        $criteria->order = 'first_name, last_name';

        foreach (User::model()->findAll($criteria) as $user) {
            if (!in_array(trim($user->first_name.' '.$user->last_name), $users)) {
                $users[] = trim($user->first_name.' '.$user->last_name);
            }
        }

        echo json_encode($users);
    }
}
