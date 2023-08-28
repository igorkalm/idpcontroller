<?php
namespace Igorkalm\IDPcontroller\Http\Controllers;

use Igorkalm\IDPcontroller\Services\QRCodesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class IDPcontroller extends Controller
{
    // IDP Controller Commands
       
    private function getControllerURL(int $acid = 0)
    {
        $url = DB::table('access_controllers')->where('id', $acid)->value('url');
        return empty($url) ? '' : $url;
    }


    /**
     * Get Access Controller Status
     *
     * @param Request $request
     * @param integer $acid
     * @return string
     */
    public function getStatus(int $acid) 
    {       
        $response = Http::get($this->getControllerURL($acid) . 'RDI');
        $status_raw = $response->body();

        $status_out = [
            'R1' => $this->parseRelayStatus($status_raw, 1), 
            'R2' => $this->parseRelayStatus($status_raw, 2),
            'status_raw' => $status_raw
        ];
        
        return json_encode($status_out);
    }


    private function parseRelayStatus($status_raw = '', $relayNumber = 0) 
    {
        $search_for = sprintf('R%d=On', $relayNumber);
        // echo $search_for . PHP_EOL;

        if ( substr_count($status_raw, $search_for) > 0 ) {
            return 'On';
        } else {
            return 'Off';
        }
    }
    

    /**
     * Getting Doors status in JSON-format
     *
     * @return string
     */
    public function getDoorsStatus(int $acid) {
        $response = Http::get($this->getControllerURL($acid) . 'RDP$B03,$B04');
        $status_raw = $response->body();
        $status_raw_a = explode(',', $status_raw);

        if (is_array($status_raw_a) && sizeof($status_raw_a)==2) {
            $status_out = [
                'd1' => $status_raw_a[0], 
                'd2' => $status_raw_a[1],
                // 'status_raw' => $status_raw
            ];
        } else {
            $status_out = [
                'd1' => 'Unknown', 
                'd2' => 'Unknown',
                // 'status_raw' => $status_raw
            ];
        }
        
        return json_encode($status_out);
    }


    public function openRelay($relay_number = 0, int $acid) {
        $response = Http::get($this->getControllerURL($acid) . sprintf('Opn0%d,5', $relay_number));
        return $response->body();
    }

 
    public function closeRelay($relay_number = 0, int $acid) {
        $response = Http::get($this->getControllerURL($acid) . sprintf('Cls0%d', $relay_number));
        return $response->body();
    }


    /**
     * Opens relay after checking QR-code as input parameter
     * 
     * @param  string $qrcode
     * @param int $door_id
     *
     * @return string
     */
    public function openByQRcode(string $qrcode, int $door_id = 0, int $acid) {
        if (QRCodesService::findQRcode( htmlentities($qrcode) )) {
            return $this->openRelay($door_id, $acid);
        } else {
            return 'QR-code is invalid.';
        }
    }


    /**
     * Receives controller events' data sent by post method
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getControllerEvent(Request $request, $idp_event = '') {
        
        if ($request->isMethod('post') && $request->accepts(['text/html', 'application/json'])) {
            $input = $request->all();
            // Debug info to log            
            // Log::debug( print_r($request->request, true) );

            $data = [
                'datetime' =>  $input['date'] . ' ' . $input['time'],
                'event' => $idp_event,
                'status' => ( $input['status']=='true' ) ? 1 : 0,
                'data' => $input['value'],
                'source' => $input['name'],
                'source_id' => $input['id'],
                'door_id' => $input['door_id'],
            ];

            $event = new \Igorkalm\IDPcontroller\Models\ControllerEvent($data);
            $event->save();

            if ( substr_count($input['value'], 'RFID:') > 0 ) {
                $qrcode_data_a = explode(' ', $input['value']);

                if ( sizeof($qrcode_data_a)>1 && $qrcode_data_a[0]=='RFID:' ) {
                    $this->openByQRcode( trim($qrcode_data_a[1]), $input['door_id'], $input['id'] );
                    // Debug info to log
                    // Log::debug( sprintf('Attempt to open relay witn QR = %s', $qrcode_data_a[1]) );
                }
            }

            return response()->json('', 200);
        }
    }

}
