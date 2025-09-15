<?php

declare(strict_types=1);

namespace DirectMailTeam\DirectMail\EventListener;

use DirectMailTeam\DirectMail\Utility\DmRegistryUtility;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Domain\Access\RecordAccessGrantedEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[AsEventListener(
    identifier: 'direct-mail/access-protected-newsletter',
)]
final readonly class AccessProtectedNewsletterEventListener
{
    public function __invoke(RecordAccessGrantedEvent $event): void
    {
        $directMailFeGroup = (int)($GLOBALS['TYPO3_REQUEST']->getQueryParams()['dmail_fe_group'] ?? null);
        $accessToken = (string)($GLOBALS['TYPO3_REQUEST']->getQueryParams()['access_token'] ?? null);
        if ($directMailFeGroup > 0 && GeneralUtility::makeInstance(DmRegistryUtility::class)->validateAndRemoveAccessToken($accessToken)) {
            $event->setAccessGranted(true);
        }
    }
}
