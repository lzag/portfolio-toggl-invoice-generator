<?php
namespace App\Model;

use App\Helper;

class TogglApi
{
    /*
     * @param string
     */
    private $api_key;

    public function __construct()
    {
        $this->api_key = Helper::configValue('toggl.api_token');
    }

    /*
     * Downloads a report from Toggl based on the dated and client provided
     */
    public function getSummaryReport($start_date, $end_date): array
    {
        $curl = curl_init();
        $url = 'https://toggl.com/reports/api/v2/summary';
        $query = [
            'workspace_id' => 4261758,
            'since'        => $start_date,
            'until'        => $end_date,
            'user_agent'   => 'api_test',
        ];
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . '?' .  http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->api_key . ':api_token',
            ));

        $payload = curl_exec($curl);

        $response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $response = [
            'response_code' => $response_code,
            'summary' => json_decode($payload),
        ];
        return $response;
    }
}
