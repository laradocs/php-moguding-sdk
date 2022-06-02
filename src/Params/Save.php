<?php

namespace Laradocs\Moguding\Params;

class Save
{
    public User $user;

    public Address $address;

    public string $planId;

    public string $device;

    public string $type;

    public ?string $description;

    public function __construct(User $user, Address $address, string $planId, string $device, string $type, ?string $description = null)
    {
        $this->user = $user;
        $this->address = $address;
        $this->planId = $planId;
        $this->device = ucfirst($device);
        $this->type = $type;
        $this->description = $description;
    }

    public function serialize(): array
    {
        return [
            'country' => $this->address->country,
            'province' => $this->address->province,
            'city' => $this->address->city,
            'address' => $this->address->address,
            'longitude' => $this->address->longitude,
            'latitude' => $this->address->latitude,
            'type' => $this->type,
            'device' => $this->device,
            'planId' => $this->planId,
            'description' => $this->description,
        ];
    }
}
