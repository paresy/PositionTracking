<?php

declare(strict_types=1);

include_once __DIR__ . '/../libs/WebHookModule.php';

class PositionTracking extends WebHookModule
{
    public function __construct($InstanceID)
    {
        parent::__construct($InstanceID, 'position_tracking/' . $InstanceID);
    }

    public function Create()
    {
        //Never delete this line!
        parent::Create();

        $this->RegisterPropertyString('APIKey', '');
        $this->RegisterPropertyInteger('SourceLatitude', 0);
        $this->RegisterPropertyInteger('SourceLongitude', 0);
        $this->RegisterPropertyInteger('UpdateLimit', 10);
        $this->RegisterPropertyString('MapWidth', '100%');
        $this->RegisterPropertyString('MapHeight', '600px');
        $this->RegisterPropertyString('HomeIcon', base64_encode(file_get_contents(__DIR__ . '/home.png')));
        $this->RegisterPropertyString('TrackerIcon', base64_encode(file_get_contents(__DIR__ . '/bulli.png')));

        $this->RegisterVariableString('Map', 'Map', '~HTMLBox');
    }

    public function Destroy()
    {
        //Never delete this line!
        parent::Destroy();
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();

        //Deleting all references in order to readd them
        foreach ($this->GetReferenceList() as $referenceID) {
            $this->UnregisterReference($referenceID);
        }

        //Delete all registrations in order to readd them
        foreach ($this->GetMessageList() as $senderID => $messages) {
            foreach ($messages as $message) {
                $this->UnregisterMessage($senderID, $message);
            }
        }

        if ($this->ReadPropertyInteger('SourceLatitude') > 0) {
            $this->RegisterMessage($this->ReadPropertyInteger('SourceLatitude'), VM_UPDATE);
            $this->RegisterReference($this->ReadPropertyInteger('SourceLatitude'));
        }
        if ($this->ReadPropertyInteger('SourceLongitude') > 0) {
            $this->RegisterMessage($this->ReadPropertyInteger('SourceLongitude'), VM_UPDATE);
            $this->RegisterReference($this->ReadPropertyInteger('SourceLongitude'));
        }

        $this->UpdateMap();
    }

    public function MessageSink($Timestamp, $SenderID, $MessageID, $Data)
    {
        if (time() - intval($this->GetBuffer('LastUpdate')) > $this->ReadPropertyInteger('UpdateLimit')) {
            $this->SendLocation($this->GetTrackerLocation());
            $this->SetBuffer('LastUpdate', strval(time()));
        }
    }

    public function SendLocation($location)
    {
        $hcID = IPS_GetInstanceListByModuleID('{015A6EB8-D6E5-4B93-B496-0D3F77AE9FE1}')[0];
        WC_PushMessage($hcID, '/hook/position_tracking/' . $this->InstanceID, $location);
    }

    private function GetDefaultLocation()
    {
        $lcID = IPS_GetInstanceListByModuleID('{45E97A63-F870-408A-B259-2933F7EABF74}')[0];
        return IPS_GetProperty($lcID, 'Location');
    }

    private function GetTrackerLocation()
    {
        if (!$this->ReadPropertyInteger('SourceLatitude') || !$this->ReadPropertyInteger('SourceLongitude')) {
            return json_encode([
                'latitude'  => 0,
                'longitude' => 0
            ]);
        }
        return json_encode([
            'latitude'  => GetValue($this->ReadPropertyInteger('SourceLatitude')),
            'longitude' => GetValue($this->ReadPropertyInteger('SourceLongitude'))
        ]);
    }

    private function UpdateMap()
    {
        if (!$this->ReadPropertyString('APIKey')) {
            $this->SetValue('Map', '<font color=red>' . $this->Translate('Google Maps API is missing') . '<font/>');
            return;
        }

        $map = file_get_contents(__DIR__ . '/map.html');

        $map = str_replace('height: 0; /* Replace Hook */', 'height: ' . $this->ReadPropertyString('MapHeight') . ';', $map);
        $map = str_replace('width: 0; /* Replace Hook */', 'width: ' . $this->ReadPropertyString('MapWidth') . ';', $map);

        $map = str_replace('map-canvas-id', 'map-canvas-' . $this->InstanceID, $map);

        $map = str_replace('{%id%}', $this->InstanceID, $map);
        $map = str_replace('{%apikey%}', $this->ReadPropertyString('APIKey'), $map);
        $map = str_replace('{%home%}', $this->GetDefaultLocation(), $map);
        $map = str_replace('{%home_icon%}', $this->ReadPropertyString('HomeIcon'), $map);
        $map = str_replace('{%tracker%}', $this->GetTrackerLocation(), $map);
        $map = str_replace('{%tracker_icon%}', $this->ReadPropertyString('TrackerIcon'), $map);

        $this->SetValue('Map', $map);
    }
}