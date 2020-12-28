<?php


namespace App\Http\Resources;


use App\Models\Replay;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiGetReplaysResource extends JsonResource
{
    public function toArray($request): array
    {
        $type = $this->user_replay === Replay::REPLAY_PRO ? 'pro' : 'user';
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'firstCountry'  => optional($this->firstCountries)->name,
            'secondCountry' => optional($this->secondCountries)->name,
            'firstRace'     => optional($this->firstRaces)->title,
            'secondRace'    => optional($this->secondRaces)->title,
            'map'           => optional($this->maps)->name,
            'mapUrl'        => optional($this->maps)->url,
            'mapUrlFull'    => optional($this->maps)->url ? asset(optional($this->maps)->url) : null,
            'type'          => !empty($this->file) ? 'Replay' : 'VOD',
            'link'          => route('replay.show', ['replay' => $this->id, 'type' => $type]),
            'createdAt'     => $this->created_at,
        ];
    }
}
