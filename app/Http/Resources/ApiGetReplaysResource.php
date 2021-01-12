<?php


namespace App\Http\Resources;


use App\Models\Replay;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiGetReplaysResource extends JsonResource
{
    public function toArray($request): array
    {
        $type = $this->user_replay === Replay::REPLAY_PRO ? 'pro' : 'user';
        $mapUrl = optional($this->maps)->url;
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'firstCountry'  => optional($this->firstCountries)->name,
            'secondCountry' => optional($this->secondCountries)->name,
            'firstRace'     => optional($this->firstRaces)->title,
            'secondRace'    => optional($this->secondRaces)->title,
            'firstName'     => $this->first_name,
            'secondName'    => $this->second_name,
            'map'           => optional($this->maps)->name,
            'mapUrl'        => $mapUrl,
            'mapUrlFull'    => !is_null($mapUrl) ? asset($mapUrl) : $mapUrl,
            'type'          => !empty($this->file) ? 'Replay' : 'VOD',
            'status'        => optional($this->types)->title,
            'link'          => route('replay.show', ['replay' => $this->id, 'type' => $type]),
        ];
    }
}
