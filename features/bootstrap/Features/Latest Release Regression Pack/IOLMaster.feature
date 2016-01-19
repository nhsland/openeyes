 @iol
Feature: To Test the process of IOLMaster imports to Biometry event
  @OE-5841  @filedrop
  Scenario Outline: To Drop DICOM file into test share for file watcher to pick it up
  Given I am on the OpenEyes "<mainPage>" homepage
  And I enter login credentials "<uname>" and "<pwd>"
  #And I close the site and firm selection popup
  And I select Site "<siteName/Number>"
  Then I select a firm of "<firmName/Number>"
  Then I open url "<url>"
  Then I choose the "<DICOMFile>" from DICOM file list
  Then I click on submit
  Then I should see "<message>" on the DICOM File Watcher page

  Examples:
  |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |
  |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417922420056.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|


   @logview
    Scenario Outline: To check the status of the dropped file in DICOM log viewer
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
  #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    And I select "<page>" from more tab
    And I select "<tab>" from the tabs on the admin page
    Then I select the "<subTab>"
    Then I look for the "<DICOMFile>" from the DICOM log and open process
     Then I verify the "<DICOMFile>" with the "<processStatus>" and "<processName>"

    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab    |DICOMFile                                                                            |processStatus|processName       |
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|Log Viewer|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417922420056.dcm|new          |runFileWatcher.php|


   @OE-5813 @fileParser
   Scenario Outline: To check the status of the dropped file in DICOM log viewer
     Given I am on the OpenEyes "<mainPage>" homepage
     And I enter login credentials "<uname>" and "<pwd>"
  #And I close the site and firm selection popup
     And I select Site "<siteName/Number>"
     Then I select a firm of "<firmName/Number>"
     And I select "<page>" from more tab
     And I select "<tab>" from the tabs on the admin page
     Then I select the "<subTab>"
     #Then I enter "<DICOMFile>" with the "<stationID>","<location>","<patientNumber>","<status>","<type>" and "<studyInstanceId>" in the search fields
     #Then I select <"dateType">, "<startDate>" and "<endDate>"
     #Then I click search
     Then I look for the "<DICOMFile>" from the DICOM log and open process
     Then I look for "<make>","<model>" and "<softwareVersion>" in machine details
     Then I search for "<patientName>" in debug data
     Then I search for "<hospitalNumber>" in debug data
     Then I search for "<birthDate>" in debug data
     Then I search for "<surgeon>" in debug data
     Then I search for "<leftAxisK1>" in debug data
     Then I search for "<leftAxisK2>" in debug data
     Then I search for "<leftK1>" in debug data
     Then I search for "<leftK2>" in debug data
     Then I search for "<leftDeltaK>" in debug data
     Then I search for "<leftDeltaKAxis>" in debug data
     Then I search for "<leftACD>" in debug data
     Then I search for "<leftAxialLength>" in debug data
     Then I search for "<leftSNR>" in debug data
     Then I search for "<rightAxisK1>" in debug data
     Then I search for "<rightAxisK2>" in debug data
     Then I search for "<rightK1>" in debug data
     Then I search for "<rightK2>" in debug data
     Then I search for "<rightDeltaK>" in debug data
     Then I search for "<rightDeltaKAxis>" in debug data
     Then I search for "<rightACD>" in debug data
     Then I search for "<rightAxialLength>" in debug data
     Then I search for "<rightSNR>" in debug data


     Examples:
       |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab    |DICOMFile                                                                            |processStatus|processName       |stationID|location|patientNumber|status|type|studyInstanceId|fileName|dateType|startDate|endDate|make|model|softwareVersion|dicomValue|patientName|hospitalNumber|birthDate|surgeon|leftAxisK1|leftAxisK2|leftK1|leftK2|leftDeltaK|leftDeltaKAxis|leftACD|leftAxialLength|leftSNR|rightAxisK1|rightAxisK2|rightK1|rightK2|rightDeltaK|rightDeltaKAxis|rightACD|rightAxialLength|rightSNR|
       |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|Log Viewer|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417922420056.dcm|new          |runFileWatcher.php|         |        |             |      |    |               |        |        |         |       |    |     |               |          |           |              |         |       |          |          |      |      |          |              |       |               |       |           |           |       |       |           |               |        |                |        |


   @iolTest_1.1
   Scenario Outline: Test Scenarios for base file format import
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
    #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    Then I open url "<url>"
    Then I choose the "<DICOMFile>" from DICOM file list
    Then I click on submit
    Then I should see "<message>" on the DICOM File Watcher page
     Then I click on "<primaryTab>" in primary selection tab
     Then I search for hospital number "<hospNum>"
     #Then I look for the "<biometryEventExists>" alert on the patient summary page
     Then I select Create or View Episodes and Events
     Then I click to expand the "<speciality>" sidebar
     Then I add a New Event "Biometry"
     Then I select a auto generated biometry event
     #Then I select a auto generated biometry event with "<eventDateTime>"
     Then I select the "<biometryTab1>" on event summary page
     #Then I look for "<info-alert1>" on event summary page
     ##Look for the values in View Mode
     ##Right Eye Values
     Then I look for "<ALValue1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<K1Value1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<K2Value1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<SNRValue1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<DeltaK1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<ACD1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<K1Deg1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<K2Deg1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<DeltaKDeg1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<eyeStatus1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     ##Left Eye Values
     Then I look for "<ALValue2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
     Then I look for "<K1Value2>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     Then I look for "<K2Value2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
     Then I look for "<SNRValue2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
     Then I look for "<DeltaK2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
     Then I look for "<ACD2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
     Then I look for "<K1Deg2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
     Then I look for "<K2Deg2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
     Then I look for "<DeltaKDeg2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
     Then I look for "<eyeStatus2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
     Then I select the "<biometryTab2>" on event summary page
     ##Look for the values in Edit mode
     ##Right Eye Values
     Then I look for "<ALValue1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<K1Value1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<K2Value1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<SNRValue1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<DeltaK1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<ACD1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<K1Deg1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<K2Deg1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<DeltaKDeg1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<eyeStatus1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     ##Left Eye Values
     Then I look for "<ALValue2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
     Then I look for "<K1Value2>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     Then I look for "<K2Value2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
     Then I look for "<SNRValue2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
     Then I look for "<DeltaK2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
     Then I look for "<ACD2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
     Then I look for "<K1Deg2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
     Then I look for "<K2Deg2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
     Then I look for "<DeltaKDeg2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
     Then I look for "<eyeStatus2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
     Then I check for "OptA119.1MA60AC" in Lens dropdown for "<eyeside1>"
     Then I check for "Opt A119.0SN60WF" in Lens dropdown for "<eyeside1>"
     Then I check for "Opt A118.7SA60AT" in Lens dropdown for "<eyeside1>"
     Then I check for "OPT 115.54 MTA3U0" in Lens dropdown for "<eyeside1>"
     Then I check for "OptA119.1MA60AC" in Lens dropdown for "<eyeside2>"
     Then I check for "Opt A119.0SN60WF" in Lens dropdown for "<eyeside2>"
     Then I check for "Opt A118.7SA60AT" in Lens dropdown for "<eyeside2>"
     Then I check for "OPT 115.54 MTA3U0" in Lens dropdown for "<eyeside2>"
     Then I check for "SRK/T" in formula dropdown for "<eyeside1>"
     Then I check for "SRK/T" in formula dropdown for "<eyeside2>"

    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab1|biometryTab2|info-alert1                              |ALValue1|K1Value1|K2Value1|SNRValue1|DeltaK1|ACD1|K1Deg1|K2Deg1|DeltaKDeg1|eyeStatus1|ALValue2|K1Value2|K2Value2|SNRValue2|DeltaK2|ACD2|K1Deg2|K2Deg2|DeltaKDeg2|eyeStatus2|eyeSide1|eyeSide2|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417921130053.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |1009600|                   |cataract  |             |View        |Edit        |The event has been added to this episode.|23.82   |42.45   |44.29   |276.2    |-1.84  |3.86|8     |98    |8         |Phakic    |24.00   |42.83   |44.12   |399.7    |-1.29  |3.91|172   |82    |172       |Phakic    |right   |left    |



@iolTest_1.2
  Scenario Outline: Test Scenarios for base file format import. Multi-Formula, Single-Lens Format
   Given I am on the OpenEyes "<mainPage>" homepage
   And I enter login credentials "<uname>" and "<pwd>"
    #And I close the site and firm selection popup
   And I select Site "<siteName/Number>"
   Then I select a firm of "<firmName/Number>"
   Then I open url "<url>"
   Then I choose the "<DICOMFile>" from DICOM file list
   Then I click on submit
   Then I should see "<message>" on the DICOM File Watcher page
   Then I click on "<primaryTab>" in primary selection tab
   Then I search for hospital number "<hospNum>"
     #Then I look for the "<biometryEventExists>" alert on the patient summary page
   Then I select Create or View Episodes and Events
   Then I click to expand the "<speciality>" sidebar
   Then I add a New Event "Biometry"
   Then I select a auto generated biometry event
     #Then I select a auto generated biometry event with "<eventDateTime>"
   Then I select the "<biometryTab1>" on event summary page
     #Then I look for "<info-alert1>" on event summary page
     ##Look for the values in View Mode
     ##Right Eye Values
   Then I look for "<ALValue1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<K1Value1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<K2Value1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<SNRValue1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<DeltaK1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<ACD1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<K1Deg1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<K2Deg1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<DeltaKDeg1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<eyeStatus1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
     ##Left Eye Values
   Then I look for "<ALValue2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
   Then I look for "<K1Value2>" in the "<eyeSide1>" biometry event "<biometryTab1>"
   Then I look for "<K2Value2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
   Then I look for "<SNRValue2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
   Then I look for "<DeltaK2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
   Then I look for "<ACD2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
   Then I look for "<K1Deg2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
   Then I look for "<K2Deg2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
   Then I look for "<DeltaKDeg2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
   Then I look for "<eyeStatus2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
   Then I select the "<biometryTab2>" on event summary page
     ##Look for the values in Edit mode
     ##Right Eye Values
   Then I look for "<ALValue1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<K1Value1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<K2Value1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<SNRValue1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<DeltaK1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<ACD1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<K1Deg1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<K2Deg1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<DeltaKDeg1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<eyeStatus1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
     ##Left Eye Values
   Then I look for "<ALValue2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
   Then I look for "<K1Value2>" in the "<eyeSide1>" biometry event "<biometryTab2>"
   Then I look for "<K2Value2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
   Then I look for "<SNRValue2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
   Then I look for "<DeltaK2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
   Then I look for "<ACD2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
   Then I look for "<K1Deg2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
   Then I look for "<K2Deg2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
   Then I look for "<DeltaKDeg2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
   Then I look for "<eyeStatus2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I check for "Opt A118.7SA60AT" in Lens dropdown for "<eyeside1>"
    Then I check for "Opt A118.7SA60AT" in Lens dropdown for "<eyeside2>"
    Then I check for "SRK/ II" in formula dropdown for "<eyeside1>"
    Then I check for "Haigis" in formula dropdown for "<eyeside1>"
    Then I check for "Holladay 2" in formula dropdown for "<eyeside1>"
    Then I check for "SRK/T" in formula dropdown for "<eyeside1>"
   Then I check for "SRK/ II" in formula dropdown for "<eyeside2>"
   Then I check for "Haigis" in formula dropdown for "<eyeside2>"
   Then I check for "Holladay 2" in formula dropdown for "<eyeside2>"
   Then I check for "SRK/T" in formula dropdown for "<eyeside2>"


    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab1|biometryTab2|info-alert1                              |ALValue1|K1Value1|K2Value1|SNRValue1|DeltaK1|ACD1|K1Deg1|K2Deg1|DeltaKDeg1|eyeStatus1|ALValue2|K1Value2|K2Value2|SNRValue2|DeltaK2|ACD2|K1Deg2|K2Deg2|DeltaKDeg2|eyeStatus2|eyeSide1|eyeSide2|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150925135344343.15295058.6463_0000_000001_144318563400b7.dcm |File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |1009601|                   |cataract  |             |View        |Edit        |The event has been added to this episode.|24.60   |41.36   |42.51   |87.3     |-1.15  |0.00|36    |126   |36        |Phakic    |24.90   |41.93   |42.45   |489.4    |-0.52  |0.00|150   |60    |150       |Phakic    |right   |left    |

    @iolTest_1.3
  Scenario Outline: Test Scenarios for base file format import with only Left Eye Data
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
   #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    Then I open url "<url>"
    Then I choose the "<DICOMFile>" from DICOM file list
    Then I click on submit
    Then I should see "<message>" on the DICOM File Watcher page
    Then I click on "<primaryTab>" in primary selection tab
    Then I search for hospital number "<hospNum>"
    #Then I look for the "<biometryEventExists>" alert on the patient summary page
    Then I select Create or View Episodes and Events
    Then I click to expand the "<speciality>" sidebar
    Then I add a New Event "Biometry"
    Then I select a auto generated biometry event
    #Then I select a auto generated biometry event with "<eventDateTime>"
    Then I select the "<biometryTab1>" on event summary page
    #Then I look for "<info-alert1>" on event summary page
    ##Look for the values in View Mode
    ##Right Eye Values
    Then I should see measurements not recorded for "<eyeSide1>" in "<biometryTab1>"
    ##Left Eye Values
    Then I look for "<ALValue2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I look for "<K1Value2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I look for "<K2Value2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I look for "<SNRValue2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I look for "<DeltaK2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I look for "<ACD2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I look for "<K1Deg2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I look for "<K2Deg2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I look for "<DeltaKDeg2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I look for "<eyeStatus2>" in the "<eyeSide2>" biometry event "<biometryTab1>"
    Then I select the "<biometryTab2>" on event summary page
    ##Look for the values in Edit mode
    ##Right Eye Values
    Then I should see measurements not recorded for "<eyeSide1>" in "<biometryTab2>"
    ##Left Eye Values
    Then I look for "<ALValue2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I look for "<K1Value2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I look for "<K2Value2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I look for "<SNRValue2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I look for "<DeltaK2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I look for "<ACD2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I look for "<K1Deg2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I look for "<K2Deg2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I look for "<DeltaKDeg2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I look for "<eyeStatus2>" in the "<eyeSide2>" biometry event "<biometryTab2>"
    Then I should see no lens recorded for "<eyeSide1>"
    Then I check for "OptA119.1MA60AC" in Lens dropdown for "<eyeside2>"
    Then I check for "Opt A119.0SN60WF" in Lens dropdown for "<eyeside2>"
    Then I check for "Opt A118.7SA60AT" in Lens dropdown for "<eyeside2>"
    Then I check for "OPT 115.54 MTA3U0" in Lens dropdown for "<eyeside2>"
    Then I should see no formula recorded for "<eyeSide1>"
    Then I check for "SRK/T" in formula dropdown for "<eyeside2>"

    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab1|biometryTab2|info-alert1                              |ALValue1|K1Value1|K2Value1|SNRValue1|DeltaK1|ACD1|K1Deg1|K2Deg1|DeltaKDeg1|eyeStatus1|ALValue2|K1Value2|K2Value2|SNRValue2|DeltaK2|ACD2|K1Deg2|K2Deg2|DeltaKDeg2|eyeStatus2|eyeSide1|eyeSide2|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417921130053.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |1009600|                   |cataract  |             |View        |Edit        |The event has been added to this episode.|23.82   |42.45   |44.29   |276.2    |-1.84  |3.86|8     |98    |8         |Phakic    |24.00   |42.83   |44.12   |399.7    |-1.29  |3.91|172   |82    |172       |Phakic    |right   |left    |


  @iolTest_1.4
  Scenario Outline: Test Scenarios for base file format import with only Right Eye Data
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
   #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    Then I open url "<url>"
    Then I choose the "<DICOMFile>" from DICOM file list
    Then I click on submit
    Then I should see "<message>" on the DICOM File Watcher page
    Then I click on "<primaryTab>" in primary selection tab
    Then I search for hospital number "<hospNum>"
    #Then I look for the "<biometryEventExists>" alert on the patient summary page
    Then I select Create or View Episodes and Events
    Then I click to expand the "<speciality>" sidebar
    Then I add a New Event "Biometry"
    Then I select a auto generated biometry event
    #Then I select a auto generated biometry event with "<eventDateTime>"
    Then I select the "<biometryTab1>" on event summary page
    #Then I look for "<info-alert1>" on event summary page
    ##Look for the values in View Mode
    ##Right Eye Values
    Then I look for "<ALValue1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K1Value1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K2Value1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<SNRValue1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<DeltaK1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<ACD1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K1Deg1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K2Deg1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<DeltaKDeg1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<eyeStatus1>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    ##Left Eye Values
    Then I should see measurements not recorded for "<eyeSide2>" in "<biometryTab1>"
    Then I select the "<biometryTab2>" on event summary page
    ##Look for the values in Edit mode
    ##Right Eye Values
    Then I look for "<ALValue1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K1Value1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K2Value1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<SNRValue1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<DeltaK1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<ACD1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K1Deg1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K2Deg1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<DeltaKDeg1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<eyeStatus1>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    ##Left Eye Values
    Then I should see measurements not recorded for "<eyeSide2>" in "<biometryTab2>"
    Then I check for "OptA119.1MA60AC" in Lens dropdown for "<eyeside1>"
    Then I check for "Opt A119.0SN60WF" in Lens dropdown for "<eyeside1>"
    Then I check for "Opt A118.7SA60AT" in Lens dropdown for "<eyeside1>"
    Then I check for "OPT 115.54 MTA3U0" in Lens dropdown for "<eyeside1>"
    Then I should see no lens recorded for "<eyeSide2>"
    Then I check for "SRK/T" in formula dropdown for "<eyeside1>"
    Then I should see no formula recorded for "<eyeSide2>"
    
    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab1|biometryTab2|info-alert1                              |ALValue1|K1Value1|K2Value1|SNRValue1|DeltaK1|ACD1|K1Deg1|K2Deg1|DeltaKDeg1|eyeStatus1|ALValue2|K1Value2|K2Value2|SNRValue2|DeltaK2|ACD2|K1Deg2|K2Deg2|DeltaKDeg2|eyeStatus2|eyeSide1|eyeSide2|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417921130053.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |1009600|                   |cataract  |             |View        |Edit        |The event has been added to this episode.|23.82   |42.45   |44.29   |276.2    |-1.84  |3.86|8     |98    |8         |Phakic    |24.00   |42.83   |44.12   |399.7    |-1.29  |3.91|172   |82    |172       |Phakic    |right   |left    |

  @iolTest_1.6
  Scenario Outline: Test Scenarios for base file format import
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
 #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    Then I open url "<url>"
    Then I choose the "<DICOMFile>" from DICOM file list
    Then I click on submit
    Then I should see "<message>" on the DICOM File Watcher page
    Then I click on "<primaryTab>" in primary selection tab
    Then I search for hospital number "<hospNum>"
  #Then I look for the "<biometryEventExists>" alert on the patient summary page
    Then I select Create or View Episodes and Events
    Then I click to expand the "<speciality>" sidebar
    Then I add a New Event "Biometry"
    Then I select a auto generated biometry event
  #Then I select a auto generated biometry event with "<eventDateTime>"
    Then I select the "<biometryTab1>" on event summary page
    Then I look for "<info-alert1>" on event summary page
  ##Look for the values in View Mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I select the "<biometryTab2>" on event summary page
  ##Look for the values in Edit mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I check for "<lensType>" in Lens dropdown for "<eyeside1>"
    Then I check for "<formula>" in formula dropdown for "<eyeside1>"



    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab|ALValue|K1Value|K2Value|eyeSide|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417922420056.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |       |                   |          |             |           |       |       |       |       |


  @iolTest_1.7
  Scenario Outline: Test Scenarios for base file format import
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
 #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    Then I open url "<url>"
    Then I choose the "<DICOMFile>" from DICOM file list
    Then I click on submit
    Then I should see "<message>" on the DICOM File Watcher page
    Then I click on "<primaryTab>" in primary selection tab
    Then I search for hospital number "<hospNum>"
  #Then I look for the "<biometryEventExists>" alert on the patient summary page
    Then I select Create or View Episodes and Events
    Then I click to expand the "<speciality>" sidebar
    Then I add a New Event "Biometry"
    Then I select a auto generated biometry event
  #Then I select a auto generated biometry event with "<eventDateTime>"
    Then I select the "<biometryTab1>" on event summary page
    Then I look for "<info-alert1>" on event summary page
  ##Look for the values in View Mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I select the "<biometryTab2>" on event summary page
  ##Look for the values in Edit mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I check for "<lensType>" in Lens dropdown for "<eyeside1>"
    Then I check for "<formula>" in formula dropdown for "<eyeside1>"



    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab|ALValue|K1Value|K2Value|eyeSide|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417922420056.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |       |                   |          |             |           |       |       |       |       |


  @iolTest_1.8
  Scenario Outline: Test Scenarios for base file format import
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
 #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    Then I open url "<url>"
    Then I choose the "<DICOMFile>" from DICOM file list
    Then I click on submit
    Then I should see "<message>" on the DICOM File Watcher page
    Then I click on "<primaryTab>" in primary selection tab
    Then I search for hospital number "<hospNum>"
  #Then I look for the "<biometryEventExists>" alert on the patient summary page
    Then I select Create or View Episodes and Events
    Then I click to expand the "<speciality>" sidebar
    Then I add a New Event "Biometry"
    Then I select a auto generated biometry event
  #Then I select a auto generated biometry event with "<eventDateTime>"
    Then I select the "<biometryTab1>" on event summary page
    Then I look for "<info-alert1>" on event summary page
  ##Look for the values in View Mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I select the "<biometryTab2>" on event summary page
  ##Look for the values in Edit mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I check for "<lensType>" in Lens dropdown for "<eyeside1>"
    Then I check for "<formula>" in formula dropdown for "<eyeside1>"



    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab|ALValue|K1Value|K2Value|eyeSide|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417922420056.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |       |                   |          |             |           |       |       |       |       |


  @iolTest_1.9
  Scenario Outline: Test Scenarios for base file format import
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
 #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    Then I open url "<url>"
    Then I choose the "<DICOMFile>" from DICOM file list
    Then I click on submit
    Then I should see "<message>" on the DICOM File Watcher page
    Then I click on "<primaryTab>" in primary selection tab
    Then I search for hospital number "<hospNum>"
  #Then I look for the "<biometryEventExists>" alert on the patient summary page
    Then I select Create or View Episodes and Events
    Then I click to expand the "<speciality>" sidebar
    Then I add a New Event "Biometry"
    Then I select a auto generated biometry event
  #Then I select a auto generated biometry event with "<eventDateTime>"
    Then I select the "<biometryTab1>" on event summary page
    Then I look for "<info-alert1>" on event summary page
  ##Look for the values in View Mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I select the "<biometryTab2>" on event summary page
  ##Look for the values in Edit mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I check for "<lensType>" in Lens dropdown for "<eyeside1>"
    Then I check for "<formula>" in formula dropdown for "<eyeside1>"



    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab|ALValue|K1Value|K2Value|eyeSide|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417922420056.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |       |                   |          |             |           |       |       |       |       |


  @iolTest_1.10
  Scenario Outline: Test Scenarios for base file format import
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
 #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    Then I open url "<url>"
    Then I choose the "<DICOMFile>" from DICOM file list
    Then I click on submit
    Then I should see "<message>" on the DICOM File Watcher page
    Then I click on "<primaryTab>" in primary selection tab
    Then I search for hospital number "<hospNum>"
  #Then I look for the "<biometryEventExists>" alert on the patient summary page
    Then I select Create or View Episodes and Events
    Then I click to expand the "<speciality>" sidebar
    Then I add a New Event "Biometry"
    Then I select a auto generated biometry event
  #Then I select a auto generated biometry event with "<eventDateTime>"
    Then I select the "<biometryTab1>" on event summary page
    Then I look for "<info-alert1>" on event summary page
  ##Look for the values in View Mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I select the "<biometryTab2>" on event summary page
  ##Look for the values in Edit mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I check for "<lensType>" in Lens dropdown for "<eyeside1>"
    Then I check for "<formula>" in formula dropdown for "<eyeside1>"



    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab|ALValue|K1Value|K2Value|eyeSide|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417922420056.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |       |                   |          |             |           |       |       |       |       |


  @iolTest_1.11
  Scenario Outline: Test Scenarios for base file format import
    Given I am on the OpenEyes "<mainPage>" homepage
    And I enter login credentials "<uname>" and "<pwd>"
 #And I close the site and firm selection popup
    And I select Site "<siteName/Number>"
    Then I select a firm of "<firmName/Number>"
    Then I open url "<url>"
    Then I choose the "<DICOMFile>" from DICOM file list
    Then I click on submit
    Then I should see "<message>" on the DICOM File Watcher page
    Then I click on "<primaryTab>" in primary selection tab
    Then I search for hospital number "<hospNum>"
  #Then I look for the "<biometryEventExists>" alert on the patient summary page
    Then I select Create or View Episodes and Events
    Then I click to expand the "<speciality>" sidebar
    Then I add a New Event "Biometry"
    Then I select a auto generated biometry event
  #Then I select a auto generated biometry event with "<eventDateTime>"
    Then I select the "<biometryTab1>" on event summary page
    Then I look for "<info-alert1>" on event summary page
  ##Look for the values in View Mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab1>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab1>"
    Then I select the "<biometryTab2>" on event summary page
  ##Look for the values in Edit mode
    Then I look for "<ALValue>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K1Value>" in the "<eyeSide1>" biometry event "<biometryTab2>"
    Then I look for "<K2Value>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<SNRValue>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaK>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<ACD>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K1Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<K2Deg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<DeltaKDeg>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I look for "<eyeStatus>" in the "<eyeSide>" biometry event "<biometryTab2>"
    Then I check for "<lensType>" in Lens dropdown for "<eyeside1>"
    Then I check for "<formula>" in formula dropdown for "<eyeside1>"



    Examples:
      |mainPage|uname|pwd  |siteName/Number|firmName/Number         |page |tab   |subTab      |DICOMFile                                                                            |message                  |url                                                          |primaryTab|hospNum|biometryEventExists|speciality|eventDateTime|biometryTab|ALValue|K1Value|K2Value|eyeSide|
      |master  |admin|admin|Barking        |Cataract firm (Cataract)|Admin|System|File Watcher|1.2.276.0.75.2.1.10.0.2.150909105354671.15295058.30971_0000_000001_14417922420056.dcm|File Copied Successfully!|http://iolmaster.openeyes.org.uk/TestHarness/DICOMFileWatcher|Home      |       |                   |          |             |           |       |       |       |       |
