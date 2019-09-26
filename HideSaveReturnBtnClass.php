<?php
// Set the namespace defined in your config file
namespace FredHutchNamespace\HideSaveReturnBtnClass;
// The next 2 lines should always be included and be the same in every module
use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;

use \REDCap;

// Declare your module class, which must extend AbstractExternalModule 
class HideSaveReturnBtnClass extends AbstractExternalModule {

    public function __construct(){
        parent::__construct();
    }

    function redcap_save_record($project_id, $record, $instrument, $event_id, $group_id, $survey_hash, $response_id, $repeat_instance)
    {
        REDCap::logEvent(__FUNCTION__, "$record - $instrument - $event_id");

        // only fire on surveys
        if (empty($survey_hash)) return;

        if (isset($_GET['__return'])) {
            // This is a save and return
            REDCap::logEvent(__FUNCTION__ . "__return", json_encode($_GET));
            REDCap::logEvent(__FUNCTION__, "Redirecting to portal");
            $this->redirectToPortal();
        } else {
            // This could be a next or real save - need to disambiguate
            // REDCap::logEvent(__FUNCTION__, "OTHER: " . json_encode($_GET));
            // // How do we tell if we are on the survey queue page as we want redirect - difficult.
            // // one option is to load the record and see if it is complete...
            // // another option is to capture the survey queue page with a different hook and do a js redirect
            // $field = $instrument . '_complete';
            // $q = REDCap::getData('json', array($record), array($field), $event_id);


            // $data = json_decode($q);

            // REDCap::logEvent("41 :", json_encode($data));

            // $result = current($data);
            
            // //REDCap::logEvent("Result for $record :", json_encode($result));


            // if (! empty($result[$field]) && $result[$field] == '2') {
            //     // survey is complete...
            //     REDCap::logEvent("Survey complete- redirect");
            //     $this->redirectToPortal();
            // } else {
            //     REDCap::logEvent("Survey $instrument not complete yet", json_encode($data));
            // }
        }
    }

    function redirectToPortal() {
        $addBtnUrl = $this->getProjectSetting('global_custom_button_url');
        redirect($addBtnUrl);
        $this->exitAfterHook();
    }

    function redcap_survey_complete($project_id, $record, $instrument, $event_id, $group_id, $survey_hash, $response_id, $repeat_instance)
    {
        REDCap::logEvent("Survey Complete Hook Called", "$record - $instrument - $event_id");
        $addBtnUrl = $this->getProjectSetting('global_custom_button_url');
        redirect($addBtnUrl);
        $this->exitAfterHook();
    }

    function redcap_survey_page($project_id, $record, $instrument, $event_id, $group_id, $repeat_instance) 
    {
        $addBtn = $this->getProjectSetting('global_show_custom_button');
        $addBtnText = $this->getProjectSetting('global_custom_button_text');
        $addBtnUrl = $this->getProjectSetting('global_custom_button_url');

        if (isset($_GET['sq'])) {
            // on the queue page
            $this-redirectToPortal();
            $this->exitAfterHook();
            return;
        }


        ?>
        <script type="text/javascript">
        $(document).ready(function() {
            var addBtn = "<?php echo $addBtn ?>";
            var addBtnText = "<?php echo $addBtnText ?>";
            var addBtnUrl = "<?php echo $addBtnUrl ?>";

            // $("button[name=\'submit-btn-savereturnlater\']").hide()
            // if (addBtn == "1")
            // {
            //     //$("button[name=\'submit-btn-savereturnlater\']").after("<button id=\'submit-btn-alt-savereturn\' tabindex=\'0\' onClick=\'window.open(\'" + addBtnUrl + "\',\'_self\');return true;\'>" + addBtnText + "</button>");
            //     $("button[name=\'submit-btn-savereturnlater\']").after("<a id=\'submit-btn-alt-savereturn\' tabindex=\'0\' class=\'jqbutton\' onClick=\'return true;\'  href=\'" + addBtnUrl + "\'>" + addBtnText + "</a>");
            // }
        });
        </script>
        <?php	
    }

}