<?php

namespace LasseRafn\InitialAvatarGenerator\Translator;

class Tr implements Base
{
    /**
     * @inheritdoc
     */
    public function translate($words)
    {
        return $words;
    }

    /**
     * @inheritdoc
     */
    public function getSourceLanguage()
    {
        return 'tr';
    }
}
