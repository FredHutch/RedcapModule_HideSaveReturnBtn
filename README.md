# RedcapModule_HideSaveReturnBtn
This REDCap module hides the Save & Return button for all surveys in a project.

## Author 
Paul Litwin, Fred Hutchinson Cancer Research Center

## Why?
For some of our projects, we construct portals that wrap around REDCap. In these projects we employ the Survey Login feature and generate random codes that are then used to tranparently open surveys on behalf of the participant. For some surveys, we allow for the updating of answers and thus need to enable the save & return later feature. But we don't wish the Save & Return button to be displayed because we want the user to be routed through the portal instead. 

## How it Works
HideSaveReturnBtn works by injecting a line of JavaScript into the survey page to hide the Save & Return button.

## Version History
* v1.1  -- provide alt button that allows you to return to a URL.
* v1.02 -- change name of module from 'hide_savereturn_btn' to 'hide_save_and_return_btn' to fix name collision.
* v1.01 -- fix to config.json issue which prevented the external module from being configured.
* v1.0  -- initial version. 2019 Aug 01.
