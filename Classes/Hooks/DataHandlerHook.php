<?php
declare(strict_types=1);

namespace DirectMailTeam\DirectMail\Hooks;

use TYPO3\CMS\Core\DataHandling\DataHandler;

final class DataHandlerHook
{
    public function processDatamap_preProcessFieldArray(
        array &$incomingFieldArray,
        string $table,
        string|int $id,
        DataHandler $dataHandler
    ): void {
        // Remove the NBSP in the sys_dmail_group table for field list
        if ($table === 'sys_dmail_group' && isset($incomingFieldArray['list'])) {
            // Remove NBSP (both HTML entity and Unicode character)
            $incomingFieldArray['list'] = str_replace(
                ['&nbsp;', "\xC2\xA0", "\xA0"],
                '',
                $incomingFieldArray['list']
            );
        }
    }
}
