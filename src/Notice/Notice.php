<?php

namespace Dbout\WpCore\Notice;

/**
 * Class Notice
 * @package Dbout\WpCore\Notice
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class Notice
{

    const TYPE_ERROR = 'error';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_INFO = 'info';

    /**
     * Type
     * ie : success, warning, ...
     *
     * @var string|null
     */
    private string $type;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var bool
     */
    private bool $dismissible = true;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Notice
     */
    public function setType(?string $type): Notice
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Notice
     */
    public function setMessage(string $message): Notice
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDismissible(): bool
    {
        return $this->dismissible;
    }

    /**
     * @param bool $dismissible
     * @return Notice
     */
    public function setDismissible(bool $dismissible): Notice
    {
        $this->dismissible = $dismissible;
        return $this;
    }
}
