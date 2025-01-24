<?php
require_once(__DIR__ . '/../config/autoload.php');

// Set SMTP server settings
ini_set('SMTP', $_ENV['SMTP']);
ini_set('smtp_port', $_ENV['smtp_port']);

class LeadDataManager
{
    /**
     * @param LeadData $data The lead data object containing the necessary information.
     * 
     * @return bool True if the email was sent successfully, False otherwise.
     */
    public static function send(LeadData $data) :bool
    {
        $headers[] = $_ENV['sender'];
        
        // Convert the associative array of lead information into an array of key-value strings
        $data->infos = array_map(
            function($k,$v) {
                return "$k : $v";
            }
            ,array_keys($data->infos), array_values($data->infos)
        );
        
       // Combine all lead information into a single string separated by new lines
        $infos = implode("\n", $data->infos);
        
        return mail(
            $_ENV['recipient'],
            'email',
            "<id_part>$data->id_part</id_part>
            <sujet>$data->code_campagne</sujet>
            <code_apporteur>$data->code_apporteur</code_apporteur>
            <informations>$infos</informations>",
            implode("\r\n", $headers)
        );   
    }
}
