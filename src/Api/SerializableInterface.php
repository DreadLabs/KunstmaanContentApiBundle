<?php

namespace DreadLabs\KunstmaanContentApiBundle\Api;

interface SerializableInterface
{

    /**
     * Returns the name of the API type (class).
     *
     * @return string
     */
    public function getApiType();
}
