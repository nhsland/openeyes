<?php

namespace OEModule\OphCiExamination\components;

/*
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

use OEModule\OphCiExamination\models;
use Patient;

class OphCiExamination_API extends \BaseAPI
{

    const LEFT = 1;
    const RIGHT = 0;

    /**
     * @inheritdoc
     */
    public function getElementFromLatestEvent($element, Patient $patient, $use_context = false)
    {
        // Ensure namespace prepended appropriately if necessary
        if (strpos($element, 'models') == 0) {
            $element = 'OEModule\OphCiExamination\\' . $element;
        }
        return parent::getElementFromLatestEvent($element, $patient, $use_context);
    }

    /**
     * Extends parent method to prepend model namespace.
     *
     * @param \Episode $episode
     * @param string $kls
     *
     * @return \BaseEventTypeElement
     * @deprecated - since 2.0
     */
    public function getElementForLatestEventInEpisode($episode, $kls)
    {
        if (strpos($kls, 'models') == 0) {
            $kls = 'OEModule\OphCiExamination\\' . $kls;
        }

        return parent::getElementForLatestEventInEpisode($episode, $kls);
    }

    /**
     * Extends parent method to prepend model namespace.
     *
     * @param $episode_id
     * @param $event_type_id
     * @param $model
     * @param $before_date
     * @return \BaseEventTypeElement
     * @deprecated since 2.0
     */
    public function getMostRecentElementInEpisode($episode_id, $event_type_id, $model, $before_date = '')
    {
        if (strpos($model, 'models') == 0) {
            $model = 'OEModule\OphCiExamination\\' . $model;
        }

        return parent::getMostRecentElementInEpisode($episode_id, $event_type_id, $model, $before_date);
    }

    /**
     * Get the patient history description field from the latest Examination event.
     * Limited to current data context.
     * Returns nothing if the latest Examination does not contain History.
     *
     * @param Patient $patient
     *
     * @return string|void
     */
    public function getLetterHistory(\Patient $patient)
    {
        if ($history = $this->getElementFromLatestEvent(
            'models\Element_OphCiExamination_History',
            $patient,
            true)
        ) {
            return strtolower($history->description);
        }
    }

    /**
     * Get the Intraocular Pressure reading for both eyes from the most recent Examination event.
     * Limited to current data context.
     * Will return the average for multiple readings on either eye.
     * Returns nothing if the latest Examination does not contain IOP.
     *
     * @param Patient $patient
     * @return string
     */
    public function getLetterIOPReadingBoth(\Patient $patient)
    {
        if ($iop = $this->getElementFromLatestEvent(
            'models\Element_OphCiExamination_IntraocularPressure',
            $patient,
            true)
        ) {
            return $iop->getLetter_reading('right') . ' on the right, and ' . $iop->getLetter_reading('left') . ' on the left';
        }
    }

    /**
     * Get the Intraocular Pressure reading for both eyes from the most recent Examination event.
     * Limited to current data context.
     * Will only return the first reading for either eye if there is more than one.
     * Returns nothing if the latest Examination does not contain IOP.
     *
     * @param Patient $patient
     * @return string
     */
    public function getLetterIOPReadingBothFirst(\Patient $patient)
    {
        if ($iop = $this->getElementFromLatestEvent(
            'models\Element_OphCiExamination_IntraocularPressure',
            $patient,
            true)
        ) {
            return $iop->getLetter_reading_first('right') . ' on the right, and ' . $iop->getLetter_reading_first('left') . ' on the left';
        }
    }

    /**
     * Get the Intraocular Pressure reading for the left eye from the most recent Examination event.
     * Limited to current data context.
     * Will return the average for multiple readings.
     * Returns nothing if the latest Examination does not contain IOP.
     *
     * @param \Patient $patient
     * @return mixed
     */
    public function getLetterIOPReadingLeft($patient)
    {
        if ($iop = $this->getElementFromLatestEvent(
            'models\Element_OphCiExamination_IntraocularPressure',
            $patient,
            true)
        ) {
            return $iop->getLetter_reading('left');
        }

    }

    /**
     * Get the Intraocular Pressure reading for the right eye from the most recent Examination event.
     * Limited to current data context.
     * Will return the average for multiple readings.
     * Returns nothing if the latest Examination does not contain IOP.
     *
     * @param \Patient $patient
     * @return mixed
     */
    public function getLetterIOPReadingRight($patient)
    {
        if ($iop = $this->getElementFromLatestEvent(
            'models\Element_OphCiExamination_IntraocularPressure',
            $patient,
            true)
        ) {
            return $iop->getLetter_reading('right');
        }
    }

    /**
     * Get an abbreviated form of the IOP readings for both eyes from the most recent Examination.
     * Limited to current data context.
     * Will return the average for multiple readings.
     * Returns nothing if the latest Examination does not contain IOP.
     *
     * @param \Patient $patient
     * @return string|null
     */
    public function getLetterIOPReadingAbbr(\Patient $patient)
    {
        if ($iop = $this->getElementFromLatestEvent(
            'models\Element_OphCiExamination_IntraocularPressure',
            $patient,
            true)
        ) {
            $readings = array();
            if (($reading = $iop->getReading('right'))) {
                $readings[] = "r:{$reading}" . ($iop->isReadingAverage('right') ? ' (avg)' : '');
            }
            if (($reading = $iop->getReading('left'))) {
                $readings[] = "l:{$reading}" . ($iop->isReadingAverage('left') ? ' (avg)' : '');
            }

            return implode(', ', $readings);
        }
    }

    /**
     * Gets IOP reading for the left eye from the latest Examination.
     * Limited to current data context.
     * Will return the average for multiple readings.
     * Returns nothing if the latest Examination does not contain IOP.
     *
     * @param \Patient $patient
     * @return mixed
     */
    public function getIOPReadingLeft(\Patient $patient)
    {
        if ($iop = $this->getElementFromLatestEvent(
            'models\Element_OphCiExamination_IntraocularPressure',
            $patient,
            true)
        ) {
            return $iop->getReading('left');
        }
    }

    /**
     * Gets IOP reading for the right eye from the latest Examination.
     * Limited to current data context.
     * Will return the average for multiple readings.
     * Returns nothing if the latest Examination does not contain IOP.
     *
     * @param \Patient $patient
     * @return mixed
     */
    public function getIOPReadingRight(\Patient $patient)
    {
        if ($iop = $this->getElementFromLatestEvent(
            'models\Element_OphCiExamination_IntraocularPressure',
            $patient,
            true)
        ) {
            return $iop->getReading('right');
        }
    }

    /**
     * Gets the last IOP reading for the left eye, regardless of whether it is in the most recent Examination or not.
     * Limited to current data context.
     * Will return the average for multiple readings.
     * Returns nothing if no IOP has been recorded.
     *
     * @todo verify if in use
     * @param \Patient $patient
     * @return string|void
     */
    public function getLastIOPReadingLeft($patient)
    {
        if ($iop = $this->getLatestElement('models\Element_OphCiExamination_IntraocularPressure',
            $patient,
            true)
        ) {
            return $iop->getReading('left');
        }
    }

    /**
     * Gets the last IOP reading for the right eye, regardless of whether it is in the most recent Examination or not.
     * Limited to current data context.
     * Will return the average for multiple readings.
     * Returns nothing if no IOP has been recorded.
     *
     * @todo verify if in use
     * @param \Patient $patient
     * @return string|void
     */
    public function getLastIOPReadingRight($patient)
    {
        if ($iop = $this->getLatestElement(
            'models\Element_OphCiExamination_IntraocularPressure',
            $patient,
            true)
        ) {
            return $iop->getReading('right');
        }
    }

    /**
     * Get the Intraocular Pressure reading for the principal eye from the most recent Examination event.
     * Limited to current data context.
     * Will return the average for multiple readings.
     * Returns nothing if the latest Examination does not contain IOP.
     *
     * @param \Patient $patient
     * @return mixed
     */
    public function getLetterIOPReadingPrincipal(\Patient $patient)
    {
        if ($eye = $this->current_context->getPrincipalEye($patient)) {
            $method = 'getLetterIOPReading' . $eye->name;
            return $this->{$method}($patient);
        }
    }

    /**
     * return the anterior segment description for the given eye. This is from the most recent
     * examination that has an anterior segment element.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side
     */
    public function getLetterAnteriorSegmentLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($as = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_AnteriorSegment')
            ) {
                return $as->left_description;
            }
        }
    }

    public function getLetterAnteriorSegmentRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($as = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_AnteriorSegment')
            ) {
                return $as->right_description;
            }
        }
    }

    public function getLetterAnteriorSegmentPrincipal($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($episode->eye) {
                $method = 'getLetterAnteriorSegment' . $episode->eye->name;

                return $this->{$method}($patient);
            }
        }
    }

    /**
     * return the posterior pole description for the given eye. This is from the most recent
     * examination that has a posterior pole element.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side
     */
    public function getLetterPosteriorPoleLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($ps = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_PosteriorPole')
            ) {
                return $ps->left_description;
            }
        }
    }

    public function getLetterPosteriorPoleRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($ps = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_PosteriorPole')
            ) {
                return $ps->right_description;
            }
        }
    }

    public function getLetterPosteriorPolePrincipal($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($episode->eye) {
                $method = 'getLetterPosteriorPole' . $episode->eye->name;

                return $this->{$method}($patient);
            }
        }
    }

    public function getRefractionValues($eventid)
    {
        if ($unit = models\Element_OphCiExamination_Refraction::model()->find('event_id = ' . $eventid)) {
            return $unit;
        }
        return;
    }

    public function getMostRecentVA($eventid)
    {
        if($vaevents = models\Element_OphCiExamination_VisualAcuity::model()->findAll('event_id = ' . $eventid)) {
            for ($i = 0; $i < count($vaevents); ++$i) {
                if($vaevents){
                    return $vaevents[$i];
                }
            }
        }
    }


    public function getMostRecentVAData($id)
    {
        if ($unit = models\OphCiExamination_VisualAcuity_Reading::model()->findAll('element_id = ' . $id)) {
            return $unit;
        }
    }


    public function getMostRecentNearVA($eventid)
    {
        if($vaevents = models\Element_OphCiExamination_NearVisualAcuity::model()->findAll('event_id = ' . $eventid)) {
            for ($i = 0; $i < count($vaevents); ++$i) {
                return $vaevents[$i];
            }
        }
    }


    public function getMostRecentNearVAData($id)
    {
        // Then findAll data from va_reading for that element_id. Most recent.
        if ($unit = models\OphCiExamination_NearVisualAcuity_Reading::model()->findAll('element_id = ' . $id)) {
            return $unit;
            }
    }


    /**
     * returns the best visual acuity for the specified side in the given episode for the patient. This is from the most recent
     * examination that has a visual acuity element.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side
     *
     * @return OphCiExamination_VisualAcuity_Reading
     */
    public function getBestVisualAcuity($patient, $episode, $side)
    {
        if ($va = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_VisualAcuity')) {
            switch ($side) {
                case 'left':
                    return $va->getBestReading('left');
                case 'right':
                    return $va->getBestReading('right');
            }
        }
    }

    public function getBestNearVisualAcuity($patient, $episode, $side)
    {
        if ($va = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_NearVisualAcuity')) {
            switch ($side) {
                case 'left':
                    return $va->getBestReading('left');
                case 'right':
                    return $va->getBestReading('right');
            }
        }
    }

    public function getVAId($patient, $episode)
    {
        if ($va = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_VisualAcuity')) {
            return $va;
        }
    }

    public function getNearVAId($patient, $episode)
    {
        if ($va = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_NearVisualAcuity')) {
            return $va;
        }
    }
    public function getVAvalue($vareading, $unitId)
    {
        if ($unit = models\OphCiExamination_VisualAcuityUnitValue::model()->find('base_value = ' . $vareading . ' AND unit_id = ' . $unitId)) {
            return $unit->value;
        }
        return;
    }

    public function getVARight($vaid)
    {
        if ($unit = models\OphCiExamination_VisualAcuity_Reading::model()->findAll('element_id = '
            . $vaid . ' AND side = ' . self::RIGHT)) {
            return $unit;
        }
        return;
    }

    public function getVALeft($vaid)
    {
        if ($unit = models\OphCiExamination_VisualAcuity_Reading::model()->findAll('element_id = '
            . $vaid . ' AND side = ' . self::LEFT)) {
            return $unit;
        }
        return;
    }


    public function getNearVARight($vaid)
    {
        if ($unit = models\OphCiExamination_NearVisualAcuity_Reading::model()->findAll('element_id = '
            . $vaid . ' AND side = ' . self::RIGHT)) {
            return $unit;
        }
        return;
    }

    public function getNearVALeft($vaid)
    {
        if ($unit = models\OphCiExamination_NearVisualAcuity_Reading::model()->findAll('element_id = '
            . $vaid . ' AND side = ' . self::LEFT)) {
            return $unit;
        }
        return;
    }


    public function getMethodIdRight($vaid, $episode)
    {
        if ($unit = models\OphCiExamination_VisualAcuity_Reading::model()->findAll('element_id = '
            . $vaid . ' AND side = ' . self::RIGHT)) {
            return $unit;
        }
        return;
    }

    public function getMethodIdNearRight($vaid)
    {
        if ($unit = models\OphCiExamination_NearVisualAcuity_Reading::model()->findAll('element_id = ' . $vaid
            . ' AND side = ' . self::RIGHT)) {
            return $unit;
        }
        return;
    }

    public function getMethodIdLeft($vaid, $episode)
    {
        if ($unit = models\OphCiExamination_VisualAcuity_Reading::model()->findAll('element_id = ' . $vaid
            . ' AND side = ' . self::LEFT)) {
            return $unit;
        }
        return;
    }

    public function getMethodIdNearLeft($vaid)
    {
        if ($unit = models\OphCiExamination_NearVisualAcuity_Reading::model()->findAll('element_id = ' . $vaid
            . ' AND side = ' . self::LEFT)) {
            return $unit;
        }
        return;
    }


    public function getUnitId($vaid, $episode)
    {
        if ($unit = models\Element_OphCiExamination_VisualAcuity::model()->find('id = ?', array($vaid))) {
            return $unit->unit_id;
        }
        return;
    }

    public function getNearUnitId($vaid, $episode)
    {
        if ($unit = models\Element_OphCiExamination_NearVisualAcuity::model()->find('id = ?', array($vaid))) {
            return $unit->unit_id;
        }
        return;
    }

    /**
     * gets the id for the Snellen Metre unit type for VA.
     *
     * @return int|null
     */
    protected function getSnellenUnitId()
    {
        if ($unit = models\OphCiExamination_VisualAcuityUnit::model()->find('name = ?', array('Snellen Metre'))) {
            return $unit->id;
        }

        return;
    }

    public function getAllVisualAcuityLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return ($best = $this->getBestVisualAcuity($patient, $episode, 'left')) ? $best->convertTo($best->value,
                $this->getSnellenUnitId()) : null;
        }
    }

    public function getAllVisualAcuityRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return ($best = $this->getBestVisualAcuity($patient, $episode, 'right')) ? $best->convertTo($best->value,
                $this->getSnellenUnitId()) : null;
        }
    }

    public function getAllVisualAcuityLeftByDate($patient, $opDate)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return ($best = $this->getBestVisualAcuity($patient, $episode, 'left')) ? $best->convertTo($best->value,
                $this->getSnellenUnitId()) : null;
        }
    }

    public function getAllVisualAcuityRightByDate($patient, $opDate)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return ($best = $this->getBestVisualAcuity($patient, $episode, 'right')) ? $best->convertTo($best->value,
                $this->getSnellenUnitId()) : null;
        }
    }


    public function getUnitName($unitId)
    {
        if ($unit = models\OphCiExamination_VisualAcuityUnit::model()->find('id = ?', array($unitId))) {
            return $unit->name;
        }
        return;
    }

    public function getMethodName($methodId)
    {
        if ($unit = models\OphCiExamination_VisualAcuity_Method::model()->find('id = ?', array($methodId))) {
            return $unit->name;
        }
        return;
    }

    public function getLetterVisualAcuityLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return ($best = $this->getBestVisualAcuity($patient, $episode, 'left')) ? $best->convertTo($best->value,
                $this->getSnellenUnitId()) : null;
        }
    }

    public function getLetterVisualAcuityRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
//            var_dump($episode);
            return ($best = $this->getBestVisualAcuity($patient, $episode, 'right')) ? $best->convertTo($best->value,
                $this->getSnellenUnitId()) : null;
        }
    }

    public function getLetterVisualAcuityBoth($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            $left = $this->getBestVisualAcuity($patient, $episode, 'left');
            $right = $this->getBestVisualAcuity($patient, $episode, 'right');

            return ($right ? $right->convertTo($right->value,
                $this->getSnellenUnitId()) : 'not recorded') . ' on the right and ' . ($left ? $left->convertTo($left->value,
                $this->getSnellenUnitId()) : 'not recorded') . ' on the left';
        }
    }

    public function getLetterVisualAcuityPrincipal($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($episode->eye) {
                $method = 'getLetterVisualAcuity' . $episode->eye->name;

                return $this->{$method}($patient);
            }
        }
    }

    /**
     * Get a combined string of the different readings. If a unit_id is given, the readings will
     * be converted to unit type of that id.
     *
     * @param string $side
     * @param null   $unit_id
     *
     * @return string
     */
    public function getCombined($side, $unit_id = null)
    {
        $combined = array();
        foreach ($this->{$side.'_readings'} as $reading) {
            $combined[] = $reading->convertTo($reading->value, $unit_id).' '.$reading->method->name;
        }

        return implode(', ', $combined);
    }

    /**
     * Get the default findings string from VA in te latest examination event (if it exists).
     *
     * @param $patient
     *
     * @return string|null
     */
    public function getLetterVisualAcuityFindings($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($va = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_VisualAcuity')
            ) {
                return $va->getLetter_string();
            }
        }
    }

    /**
     * get the va from the given episode for the left side of the episode patient.
     * @param Episode $episode
     * @param bool $include_nr_values
    <<<<<<< HEAD
     *
    =======
     * @param string $before_date
    >>>>>>> develop
     * @return OphCiExamination_VisualAcuity_Reading
     */
    public function getLetterVisualAcuityForEpisodeLeft($episode, $include_nr_values = false, $before_date = '')
    {
        $event_type = $this->getEventType();
        if ($va = $this->getMostRecentElementInEpisode(
            $episode->id,
            $event_type->id,
            'models\Element_OphCiExamination_VisualAcuity',
            $before_date
        )) {
            if ($va->hasLeft()) {
                if ($best = $va->getBestReading('left')) {
                    return $best->convertTo($best->value, $this->getSnellenUnitId());
                } elseif ($include_nr_values) {
                    return $va->getTextForSide('left');
                }
            }
        }
    }

    /**
     * get the va from the given episode for the right side of the episode patient.
     * @param Episode $episode
    <<<<<<< HEAD
     * @param bool $include_nr_values
     *
    =======
     * @param bool    $include_nr_values
     * @param string $before_date
    >>>>>>> develop
     * @return OphCiExamination_VisualAcuity_Reading
     */
    public function getLetterVisualAcuityForEpisodeRight($episode, $include_nr_values = false, $before_date = '')
    {
        $event_type = $this->getEventType();
        if ($va = $this->getMostRecentElementInEpisode(
            $episode->id,
            $event_type->id,
            'models\Element_OphCiExamination_VisualAcuity',
            $before_date
        )) {
            if ($va->hasRight()) {
                if ($best = $va->getBestReading('right')) {
                    return $best->convertTo($best->value, $this->getSnellenUnitId());
                } elseif ($include_nr_values) {
                    return $va->getTextForSide('right');
                }
            }
        }
    }

    /**
     * Get the VA string for both sides.
     *
     * @param $episode
     * @param bool $include_nr_values flag to indicate whether NR flag values should be used for the text
     *
     * @return string
     */
    public function getLetterVisualAcuityForEpisodeBoth($episode, $include_nr_values = false)
    {
        $left = $this->getLetterVisualAcuityForEpisodeLeft($episode, $include_nr_values);
        $right = $this->getLetterVisualAcuityForEpisodeRight($episode, $include_nr_values);

        return ($right ? $right : 'not recorded') . ' on the right and ' . ($left ? $left : 'not recorded') . ' on the left';
    }

    /**
     * get the list of possible unit values for Visual Acuity.
     *
     * currently operates on the assumption there is always Snellen Metre available as a VA unit, and provides this
     * exclusively.
     */
    public function getVAList()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('name = :nm');
        $criteria->params = array(':nm' => 'Snellen Metre');

        $unit = models\OphCiExamination_VisualAcuityUnit::model()->find($criteria);
        $res = array();
        foreach ($unit->selectableValues as $uv) {
            $res[$uv->base_value] = $uv->value;
        }

        return $res;
    }

    /**
     * get the conclusion text from the most recent examination in the patient examination that has a conclusion element.
     *
     * @param \Patient $patient
     *
     * @return string
     */
    public function getLetterConclusion($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($conclusion = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_Conclusion')
            ) {
                return $conclusion->description;
            }
        }
    }

    /**
     * get the letter txt from the management element for the given patient and episode. This is from the most recent
     * examination that has a management element.
     *
     * @param \Patient $patient
     *
     * @return string
     */
    public function getLetterManagement($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($management = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_Management')
            ) {
                return $management->comments;
            }
        }
    }

    /**
     * return the adnexal comorbidity for the patient episode on the given side. This is from the most recent examination that
     * has an adnexal comorbidity element.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side
     */
    public function getLetterAdnexalComorbidityRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($ac = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_AdnexalComorbidity')
            ) {
                return $ac->right_description;
            }
        }
    }

    public function getLetterAdnexalComorbidityLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($ac = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_AdnexalComorbidity')
            ) {
                return $ac->left_description;
            }
        }
    }

    /**
     * Get the NSC Retinopathy grade.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side 'left' or 'right'
     *
     * @return string
     */
    public function getLetterDRRetinopathy($patient, $episode, $side)
    {
        if ($dr = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_DRGrading')) {
            $res = $dr->{$side . '_nscretinopathy'};
            if ($dr->{$side . '_nscretinopathy_photocoagulation'}) {
                $res .= ' and evidence of photocoagulation';
            } else {
                $res .= ' and no evidence of photocoagulation';
            }

            return $res;
        }
    }

    public function getLetterDRRetinopathyLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return $this->getLetterDRRetinopathy($patient, $episode, 'left');
        }
    }

    public function getLetterDRRetinopathyRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return $this->getLetterDRRetinopathy($patient, $episode, 'right');
        }
    }

    /**
     * Get the NSC Maculopathy grade.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side 'left' or 'right'
     *
     * @return string
     */
    public function getDRMaculopathy($patient, $episode, $side)
    {
        if ($dr = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_DRGrading')) {
            $res = $dr->{$side . '_nscmaculopathy'};
            if ($dr->{$side . '_nscmaculopathy_photocoagulation'}) {
                $res .= ' and evidence of photocoagulation';
            } else {
                $res .= ' and no evidence of photocoagulation';
            }

            return $res;
        }
    }

    public function getLetterDRMaculopathyLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return $this->getDRMaculopathy($patient, $episode, 'left');
        }
    }

    public function getLetterDRMaculopathyRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return $this->getDRMaculopathy($patient, $episode, 'right');
        }
    }

    /**
     * Get the clinical diabetic retinopathy grade.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side 'left' or 'right'
     *
     * @return string
     */
    public function getDRClinicalRet($patient, $episode, $side)
    {
        if ($dr = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_DRGrading')) {
            if ($ret = $dr->{$side . '_clinicalret'}) {
                return $ret->name;
            };
        }
    }

    public function getLetterDRClinicalRetLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return $this->getDRClinicalRet($patient, $episode, 'left');
        }
    }

    public function getLetterDRClinicalRetRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return $this->getDRClinicalRet($patient, $episode, 'right');
        }
    }

    /**
     * Get the clinical diabetic maculopathy grade.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side 'left' or 'right'
     *
     * @return string
     */
    public function getDRClinicalMac($patient, $episode, $side)
    {
        if ($dr = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_DRGrading')) {
            if ($mac = $dr->{$side . '_clinicalmac'}) {
                return $mac->name;
            }
        }
    }

    public function getLetterDRClinicalMacLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return $this->getDRClinicalMac($patient, $episode, 'left');
        }
    }

    public function getLetterDRClinicalMacRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            return $this->getDRClinicalMac($patient, $episode, 'right');
        }
    }

    /**
     * get the laser management plan.
     *
     * @param Patient $patient
     *
     * @deprecated since 1.4.10, user getLetterLaserManagementFindings($patient)
     */
    public function getLetterLaserManagementPlan($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($m = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_LaserManagement')
            ) {
                return $m->getLetter_string();
            }
        }
    }

    /**
     * Get the default findings string from VA in te latest examination event (if it exists).
     *
     * @param $patient
     *
     * @return string|null
     */
    public function getLetterLaserManagementFindings($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($va = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_LaserManagement')
            ) {
                return $va->getLetter_string();
            }
        }
    }

    /**
     * get laser management comments.
     *
     * @param Patient $patient
     *
     * @return string
     */
    public function getLetterLaserManagementComments($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($m = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_Management')) {
                return $m->comments;
            }
        }
    }

    /**
     * get follow up period from clinical outcome.
     *
     * @param Patient $patient
     *
     * @return string
     */
    public function getLetterOutcomeFollowUpPeriod($patient)
    {
        if ($api = \Yii::app()->moduleAPI->get('PatientTicketing')) {
            if ($patient_ticket_followup = $api->getLatestFollowUp($patient)) {
                if (@$patient_ticket_followup['followup_quantity'] == 1 && @$patient_ticket_followup['followup_period']) {
                    $patient_ticket_followup['followup_period'] = rtrim($patient_ticket_followup['followup_period'],
                        's');
                }

                return $patient_ticket_followup['followup_quantity'] . ' ' . $patient_ticket_followup['followup_period'] . ' in the ' . $patient_ticket_followup['clinic_location'];
            }
        }

        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($o = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_ClinicOutcome')
            ) {
                if ($o->followup_quantity) {
                    return $o->followup_quantity . ' ' . $o->followup_period;
                }
            }
        }
    }

    /**
     * gets a list of disorders diagnosed for the patient within the current episode, ordered by event creation date.
     *
     * @param Patient $patient
     *
     * @return array() - list of associative arrays with disorder_id and eye_id defined
     */
    public function getOrderedDisorders($patient, $episode)
    {
        $events = $this->getEventsInEpisode($patient, $episode);
        $disorders = array();

        if ($events) {
            foreach (@$events as $event) {
                $criteria = new \CDbCriteria();
                $criteria->compare('event_id', $event->id);

                $diagnoses_el = models\Element_OphCiExamination_Diagnoses::model()->find($criteria);
                if ($diagnoses_el) {
                    foreach ($diagnoses_el->diagnoses as $diagnosis) {
                        $disorders[] = array('disorder_id' => $diagnosis->disorder_id, 'eye_id' => $diagnosis->eye_id);
                    }
                }
            }
        }

        return $disorders;
    }

    public function getLetterStringForModel($patient, $episode, $element_type_id)
    {
        if (!$element_type = \ElementType::model()->findByPk($element_type_id)) {
            throw new Exception("Unknown element type: $element_type_id");
        }
        if ($element = $this->getElementForLatestEventInEpisode($episode, $element_type->class_name)) {
            return $element->letter_string;
        }
    }

    /**
     * returns all the elements from the most recent examination of the patient in the given episode.
     *
     * @param \Patient $patient
     * @param \Episode $episode
     *
     * @return \ElementType[] - array of various different element type objects
     */
    public function getElementsForLatestEventInEpisode($patient, $episode)
    {
        $element_types = array();

        $event_type = $this->getEventType();

        if ($event_type && $event = $this->getMostRecentEventInEpisode($episode->id, $event_type->id)) {
            $criteria = new \CDbCriteria();
            $criteria->compare('event_type_id', $event_type->id);
            $criteria->order = 'display_order';

            foreach (\ElementType::model()->findAll($criteria) as $element_type) {
                $class = $element_type->class_name;

                if ($element = $class::model()->find('event_id=?', array($event->id))) {
                    if (method_exists($element, 'getLetter_string')) {
                        $element_types[] = $element_type;
                    }
                }
            }
        }

        return $element_types;
    }

    /**
     * Get the most recent InjectionManagementComplex element in this episode for the given side.
     *
     * N.B. This is different from letter functions as it will return the most recent Injection Management Complex
     * element, regardless of whether it is part of the most recent examination event, or an earlier one.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side
     *
     * @return models\Element_OphCiExamination_InjectionManagementComplex
     */
    public function getInjectionManagementComplexInEpisodeForSide($patient, $episode, $side)
    {
        $events = $this->getEventsInEpisode($patient, $episode);

        $eye_vals = array(\Eye::BOTH);
        if ($side == 'left') {
            $eye_vals[] = \Eye::LEFT;
        } else {
            $eye_vals[] = \Eye::RIGHT;
        }
        foreach (@$events as $event) {
            $criteria = new \CDbCriteria();
            $criteria->compare('event_id', $event->id);
            $criteria->addInCondition('eye_id', $eye_vals);

            if ($el = models\Element_OphCiExamination_InjectionManagementComplex::model()->find($criteria)) {
                return $el;
            }
        }
    }

    /**
     * Get the most recent InjectionManagementComplex element in this episode for the given side and disorder.
     *
     * N.B. This is different from letter functions as it will return the most recent Injection Management Complex element,
     * regardless of whether it is part of the most recent examination event, or an earlier one.
     *
     * @param Patient $patient
     * @param Episode $episode
     * @param string $side
     * @param int $disorder1_id
     * @param int $disorder2_id
     *
     * @return models\Element_OphCiExamination_InjectionManagementComplex
     */
    public function getInjectionManagementComplexInEpisodeForDisorder(
        $patient,
        $episode,
        $side,
        $disorder1_id,
        $disorder2_id
    ) {
        $events = $this->getEventsInEpisode($patient, $episode);
        $elements = array();

        if ($events) {
            foreach ($events as $event) {
                $criteria = new \CDbCriteria();
                $criteria->compare('event_id', $event->id);
                $criteria->compare($side . '_diagnosis1_id', $disorder1_id);
                if ($disorder2_id) {
                    $criteria->compare($side . '_diagnosis2_id', $disorder2_id);
                } else {
                    $criteria->addCondition($side . '_diagnosis2_id IS NULL OR ' . $side . '_diagnosis2_id = 0');
                }

                if ($el = models\Element_OphCiExamination_InjectionManagementComplex::model()->find($criteria)) {
                    return $el;
                }
            }
        }
    }

    /**
     * wrapper to retrieve question objects for a given disorder id.
     *
     * @param int $disorder_id
     *
     * @return models\OphCiExamination_InjectionMangementComplex_Question[]
     */
    public function getInjectionManagementQuestionsForDisorder($disorder_id)
    {
        try {
            models\Element_OphCiExamination_InjectionManagementComplex::model()->getInjectionQuestionsForDisorderId($disorder_id);
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * return the most recent Injection Management Complex examination element in the given episode.
     *
     * @param Episode $episode
     * @param DateTime $after
     *
     * @return OphCiExamination_InjectionManagementComplex|null
     */
    public function getLatestInjectionManagementComplex($episode, $after = null)
    {
        $events = $this->getEventsInEpisode($episode->patient, $episode);

        foreach ($events as $event) {
            $criteria = new \CDbCriteria();
            $criteria->addCondition('event_id = ?');
            $criteria->params = array($event->id);
            if ($after) {
                $criteria->addCondition('created_date > ?');
                $criteria->params[] = $after->format('Y-m-d H:i:s');
            }
            if ($el = models\Element_OphCiExamination_InjectionManagementComplex::model()->find($criteria)) {
                return $el;
            }
        }
    }

    /**
     * retrieve OCT measurements for the given side for the patient in the given episode.
     *
     * N.B. This is different from letter functions as it will return the most recent OCT element, regardless of whether
     * it is part of the most recent examination event, or an earlier one.
     *
     * @param \Patient $patient
     * @param \Episode $episode
     * @param string $side - 'left' or 'right'
     *
     * @return array(maximum_CRT, central_SFT) or null
     */
    public function getOCTForSide($patient, $episode, $side)
    {
        $events = $this->getEventsInEpisode($patient, $episode);
        if ($side == 'left') {
            $side_list = array(\Eye::LEFT, \Eye::BOTH);
        } else {
            $side_list = array(\Eye::RIGHT, \Eye::BOTH);
        }
        if ($events) {
            foreach ($events as $event) {
                $criteria = new \CDbCriteria();
                $criteria->compare('event_id', $event->id);
                $criteria->addInCondition('eye_id', $side_list);

                if ($el = models\Element_OphCiExamination_OCT::model()->find($criteria)) {
                    return array($el->{$side . '_crt'}, $el->{$side . '_sft'});
                }
            }
        }
    }

    /**
     * Get previous SFT values for the given epsiode and side. Before $before, or all available.
     *
     * @param \Episode $episode
     * @param string $side
     * @param date $before
     *
     * @return array
     */
    public function getOCTSFTHistoryForSide($episode, $side, $before = null)
    {
        if ($events = $this->getEventsInEpisode($episode->patient, $episode)) {
            if ($side == 'left') {
                $side_list = array(\Eye::LEFT, \Eye::BOTH);
            } else {
                $side_list = array(\Eye::RIGHT, \Eye::BOTH);
            }
            $res = array();
            foreach ($events as $event) {
                $criteria = new \CDbCriteria();
                $criteria->compare('event_id', $event->id);
                $criteria->addInCondition('eye_id', $side_list);
                if ($before) {
                    $criteria->addCondition('event.created_date < :edt');
                    $criteria->params[':edt'] = $before;
                }

                if ($el = models\Element_OphCiExamination_OCT::model()->with('event')->find($criteria)) {
                    $res[] = array('date' => $event->created_date, 'sft' => $el->{$side . '_sft'});
                }
            }

            return $res;
        }
    }

    /**
     * retrieve the Investigation Description for the given patient.
     *
     * @param $patient
     *
     * @return mixed
     */
    public function getLetterInvestigationDescription($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($el = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_Investigation')
            ) {
                return $el->description;
            }
        }
    }

    /**
     * get the maximum CRT for the patient for the given side.
     *
     * @param $patient
     * @param $side
     *
     * @return mixed
     */
    public function getLetterMaxCRTForSide($patient, $side)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($el = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_OCT')) {
                return $el->{$side . '_crt'} . 'um';
            }
        }
    }

    /**
     * wrapper function to get the Maximum CRT for the left side of the patient.
     *
     * @param $patient
     *
     * @return mixed
     */
    public function getLetterMaxCRTLeft($patient)
    {
        return $this->getLetterMaxCRTForSide($patient, 'left');
    }

    /**
     * wrapper function to get the Maximum CRT for the right side of the patient.
     *
     * @param $patient
     *
     * @return mixed
     */
    public function getLetterMaxCRTRight($patient)
    {
        return $this->getLetterMaxCRTForSide($patient, 'right');
    }

    /**
     * Get the central SFT for the given patient for the given side.
     *
     * @param $patient
     * @param $side
     *
     * @return mixed
     */
    public function getLetterCentralSFTForSide($patient, $side)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($el = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_OCT')) {
                return $el->{$side . '_sft'} . 'um';
            }
        }
    }

    /**
     * wrapper function to get the Central SFT for the left side of the patient.
     *
     * @param $patient
     *
     * @return mixed
     */
    public function getLetterCentralSFTLeft($patient)
    {
        return $this->getLetterCentralSFTForSide($patient, 'left');
    }

    /**
     * wrapper function to get the Central SFT for the right side of the patient.
     *
     * @param $patient
     *
     * @return mixed
     */
    public function getLetterCentralSFTRight($patient)
    {
        return $this->getLetterCentralSFTForSide($patient, 'right');
    }

    /**
     * get the diagnosis description for the patient on the given side from the injection management complex element in the most
     * recent examination, if there is one.
     *
     * @param $patient
     * @param $side
     *
     * @return string
     */
    public function getLetterInjectionManagementComplexDiagnosisForSide($patient, $side)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($el = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_InjectionManagementComplex')
            ) {
                if ($d = $el->{$side . '_diagnosis1'}) {
                    $res = $d->term;
                    if ($d2 = $el->{$side . '_diagnosis2'}) {
                        $res .= ' associated with ' . $d2->term;
                    }

                    return $res;
                }
            }
        }
    }

    /**
     * get the diagnosis description for the patient on the left.
     *
     * @param $patient
     *
     * @return string
     *
     * @see getLetterInjectionManagementComplexDiagnosisForSide
     */
    public function getLetterInjectionManagementComplexDiagnosisLeft($patient)
    {
        return $this->getLetterInjectionManagementComplexDiagnosisForSide($patient, 'left');
    }

    /**
     * get the diagnosis description for the patient on the right.
     *
     * @param $patient
     *
     * @return string
     *
     * @see getLetterInjectionManagementComplexDiagnosisForSide
     */
    public function getLetterInjectionManagementComplexDiagnosisRight($patient)
    {
        return $this->getLetterInjectionManagementComplexDiagnosisForSide($patient, 'right');
    }

    /**
     * Get the default findings string from Injection Management complex in the latest examination event (if it exists).
     *
     * @TODO: make this work with both injection management elements (i.e. if complex not being used, use basic)
     *
     * @param $patient
     *
     * @return string|null
     */
    public function getLetterInjectionManagementComplexFindings($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($el = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_InjectionManagementComplex')
            ) {
                return $el->getLetter_string();
            }
        }
    }

    /**
     * get the combined string for both eyes injection management complex diagnosis.
     *
     * @param $patient
     *
     * @return string
     */
    public function getLetterInjectionManagementComplexDiagnosisBoth($patient)
    {
        $right = $this->getLetterInjectionManagementComplexDiagnosisRight($patient);
        $left = $this->getLetterInjectionManagementComplexDiagnosisLeft($patient);
        if ($right || $left) {
            $res = '';
            if ($right) {
                $res = 'Right Eye: ' . $right;
            }
            if ($left) {
                if ($right) {
                    $res .= "\n";
                }
                $res .= 'Left Eye: ' . $left;
            }

            return $res;
        }
    }

    /**
     * get principal eye CCT values for current episode, examination event.
     *
     * @param $patient
     *
     * @return string
     */
    public function getPrincipalCCT($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            $str = '';

            if (!isset($episode->eye->name)) {
                return;
            }
            $eyeName = $episode->eye->name;

            if ($el = $this->getMostRecentElementInEpisode($episode->id, $this->getEventType()->id,
                'OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT')
            ) {
                if (isset($el->left_value) && ($eyeName == 'Left' || $eyeName == 'Both')) {
                    $str = $str . 'Left Eye: ' . $el->left_value . ' µm using ' . $el->left_method->name . '. ';
                }
                if (isset($el->right_value) && ($eyeName == 'Right' || $eyeName == 'Both')) {
                    $str = $str . 'Right Eye: ' . $el->right_value . ' µm using ' . $el->right_method->name . '. ';
                }
            }

            return $str;
        }
    }

    /**
     * get principal eye Gonioscopy Van Herick values for current episode, examination event.
     *
     * @param $patient
     *
     * @return string
     */
    public function getPrincipalVanHerick($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            $str = '';

            if (!isset($episode->eye->name)) {
                return;
            }
            $eyeName = $episode->eye->name;

            if ($el = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_Gonioscopy')
            ) {
                if (isset($el->left_van_herick) && ($eyeName == 'Left' || $eyeName == 'Both')) {
                    $str = $str . 'Left Eye: Van Herick grade is ' . $el->left_van_herick->name . '. ';
                }
                if (isset($el->right_van_herick) && ($eyeName == 'Right' || $eyeName == 'Both')) {
                    $str = $str . 'Right Eye: Van Herick grade is ' . $el->right_van_herick->name . '. ';
                }
            }

            return $str;
        }
    }

    /**
     * get principal eye Optic Disc description for current episode, examination event.
     *
     * @param $patient
     *
     * @return string
     */
    public function getPrincipalOpticDiscDescription($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            $str = '';

            if (!isset($episode->eye->name)) {
                return;
            }
            $eyeName = $episode->eye->name;

            if ($el = $this->getElementForLatestEventInEpisode($episode, 'models\Element_OphCiExamination_OpticDisc')) {
                if (isset($el->left_description) && ($eyeName == 'Left' || $eyeName == 'Both')) {
                    $str = $str . 'Left Eye: ' . $el->left_description . '. ';
                }
                if (isset($el->right_description) && ($eyeName == 'Right' || $eyeName == 'Both')) {
                    $str = $str . 'Right Eye: ' . $el->right_description . '. ';
                }
            }

            return $str;
        }
    }

    /**
     * Get the latest left CCT measurement.
     *
     * @param \Patient $patient
     *
     * @return string
     */
    public function getCCTLeft($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($el = $this->getMostRecentElementInEpisode($episode->id, $this->getEventType()->id,
                'OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT')
            ) {
                if ($el->hasLeft()) {
                    return $el->left_value . ' µm';
                }
            }
        }
    }

    public function getCCTLeftNoUnits($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($el = $this->getMostRecentElementInEpisode($episode->id, $this->getEventType()->id,
                'OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT')
            ) {
                if ($el->hasLeft()) {
                    return $el->left_value;
                }
            }
        }

        return 'NR';
    }

    /**
     * Get the latest right CCT measurement.
     *
     * @param \Patient $patient
     *
     * @return string
     */
    public function getCCTRight($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($el = $this->getMostRecentElementInEpisode($episode->id, $this->getEventType()->id,
                'OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT')
            ) {
                if ($el->hasRight()) {
                    return $el->right_value . ' µm';
                }
            }
        }
    }

    public function getCCTRightNoUnits($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($el = $this->getMostRecentElementInEpisode($episode->id, $this->getEventType()->id,
                'OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT')
            ) {
                if ($el->hasRight()) {
                    return $el->right_value;
                }
            }
        }

        return 'NR';
    }

    /**
     * @param Patient $patient
     *
     * @return string|null;
     */
    public function getCCTAbbr(\Patient $patient)
    {
        if (($episode = $patient->getEpisodeForCurrentSubspecialty()) &&
            ($cct = $this->getMostRecentElementInEpisode($episode->id, $this->getEventType()->id,
                'OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT'))
        ) {
            $readings = array();
            if ($cct->hasRight()) {
                $readings[] = 'r:' . $cct->right_value;
            }
            if ($cct->hasLeft()) {
                $readings[] = 'l:' . $cct->left_value;
            }

            return implode(', ', $readings);
        } else {
            return;
        }
    }

    /**
     * Get the glaucoma risk as a string for the patient - we get this from the most recent examination that has a glaucoma risk recording
     * as it's possible that it's not going to be recorded each time.
     *
     * @param \Patient $patient
     *
     * @return mixed
     */
    public function getGlaucomaRisk($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            $event_type = $this->getEventType();
            if ($el = $this->getMostRecentElementInEpisode($episode->id, $event_type->id,
                'models\Element_OphCiExamination_GlaucomaRisk')
            ) {
                return $el->risk->name;
            }
        }
    }

    public function getIOPReadingLeftNoUnits($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($iop = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_IntraocularPressure')
            ) {
                if ($reading = $iop->getReading('left')) {
                    return $reading;
                }
            }
        }

        return 'NR';
    }

    public function getIOPReadingRightNoUnits($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($iop = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_IntraocularPressure')
            ) {
                if ($reading = $iop->getReading('right')) {
                    return $reading;
                }
            }
        }

        return 'NR';
    }

    public function getIOPValuesAsTable($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($iop = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_IntraocularPressure')
            ) {
                $iopVals = $iop->getValues();
                $i = 0;
                $output = '<table>';
                while (isset($iopVals['right'][$i]) || isset($iopVals['left'][$i])) {
                    if ($i === 0) {
                        $lCCT = $this->getCCTLeftNoUnits($patient);
                        $rCCT = $this->getCCTRightNoUnits($patient);
                        $output .= '<tr><th class="large-6">RE [' . $rCCT . ']</th><th class="large-6">LE [' . $lCCT . ']</th></tr>';
                    }

                    $output .= '<tr>';
                    if (isset($iopVals['right'][$i])) {
                        $right = $iopVals['right'][$i];
                        $instr = (isset($right->instrument->short_name) && strlen($right->instrument->short_name) > 0) ?
                            $right->instrument->short_name : $right->instrument->name;
                        $readingNameRight = $right->instrument->scale ? $right->qualitative_reading->name : $right->reading->name;
                        $output .= '<td>' . $readingNameRight . ':' . $instr . '</td>';
                    } else {
                        $output .= '<td>&nbsp;</td>';
                    }
                    if (isset($iopVals['left'][$i])) {
                        $left = $iopVals['left'][$i];
                        $instr = (isset($left->instrument->short_name) && strlen($left->instrument->short_name) > 0) ?
                            $left->instrument->short_name : $left->instrument->name;
                        $readingNameLeft = $left->instrument->scale ? $left->qualitative_reading->name : $left->reading->name;
                        $output .= '<td>' . $readingNameLeft . ':' . $instr . '</td>';
                    } else {
                        $output .= '<td>&nbsp;</td>';
                    }
                    $output .= '</tr>';
                    ++$i;
                }
                $output .= '</table>';

                return $output;
            }
        }

        return '';
    }

    public function getTargetIOP($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($oManPlan = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_OverallManagementPlan')
            ) {
                return array(
                    'left' => ($oManPlan->left_target_iop ? $oManPlan->left_target_iop->name : null),
                    'right' => ($oManPlan->right_target_iop ? $oManPlan->right_target_iop->name : null),
                );
            }
        }

        return;
    }

    public function getLetterDiagnosesAndFindings($patient)
    {
        if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
            if ($diag = $this->getElementForLatestEventInEpisode($episode,
                'models\Element_OphCiExamination_Diagnoses')
            ) {
                return $diag->letter_string;
            }
        }

        return;
    }

    /**
     * Return list of allergies belonging to a patient.
     *
     * @param \Patient $patient
     *
     * @return string
     */
    public function getAllergies(\Patient $patient)
    {
        if (count($patient->allergies)) {
            return $patient->getAllergiesSeparatedString($prefix='', $separator=', ', $lastSeparatorNeeded=false);
        }

        return 'none';
    }

    /**
     * To get the most recent VA element for the Patient
     *
     * @param \Patient $patient
     * @return array|bool
     */
    public function getMostRecentVAElementForPatient(\Patient $patient)
    {
        $event_type = $this->getEventType();
        $criteria = new \CDbCriteria;
        $criteria->select = '*';
        $criteria->join = 'join episode on t.episode_id = episode.id and patient_id = :patient_id and event_type_id = :event_type_id';
        $criteria->order = 't.event_date desc';
        $criteria->condition = 't.deleted != 1';
        $criteria->params = array(':patient_id' => $patient->id, ':event_type_id' => $event_type->id);
        foreach (\Event::model()->findAll($criteria) as $event) {
            $result_element = models\Element_OphCiExamination_VisualAcuity::model()
                ->with('event')
                ->find('event_id=?', array($event->id));
            if ($result_element !== null) {
                return (array('element' => $result_element, 'event_date' => date($event->created_date)));
            }
        }

        return false;
    }

    public static $UNAIDED_VA_TYPE = 'unaided';
    public static $AIDED_VA_TYPE = 'aided';

    /**
     * To get the visual acuity from the element based on the all episodes for the patient
     * @param \Patient $patient
     * @param $side
     * @param $type
     * @param $element
     * @return null
     * @throws \Exception
     */
    public function getMostRecentVAForPatient(\Patient $patient, $side, $type,$element)
    {
        if (!in_array($type, array(static::$AIDED_VA_TYPE, static::$UNAIDED_VA_TYPE))) {
            throw new \Exception("Invalid type for VA {$type}");
        }
        $checkFunc = 'has' . ucfirst($side);
        if (!$element->$checkFunc()) {
            return null;
        }

        $method_type = $type == static::$AIDED_VA_TYPE
            ? models\OphCiExamination_VisualAcuity_Method::$AIDED_FLAG_TYPE
            : models\OphCiExamination_VisualAcuity_Method::$UNAIDED_FLAG_TYPE;

        $methods = models\OphCiExamination_VisualAcuity_Method::model()->findAll('type=?', array($method_type));
        $best_reading = $element->getBestReadingByMethods($side, $methods);
        return $best_reading;
    }
}
