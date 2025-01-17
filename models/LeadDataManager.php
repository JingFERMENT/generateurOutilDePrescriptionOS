<?php
require_once(__DIR__ . '/../config/autoload.php');

ini_set('SMTP', $_ENV['SMTP']);
ini_set('smtp_port', $_ENV['smtp_port']);

class LeadDataManager
{
    public static function send(LeadData $data)
    {
        // configuration des en-têtes
        $headers[] = $_ENV['sender'];

        $data->infos = array_map(
            function($k,$v) {return "$k : $v";}
            ,array_keys($data->infos), array_values($data->infos)
        );
        
       // stock all the information
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
