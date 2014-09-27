<?php
/**
 * Created by PhpStorm.
 * User: Vitaly
 * Date: 26.09.2014
 * Time: 19:16
 */

class CommonHelper {

    public static function assert($value, $display_message, $message_to_log = '', $message_data = [])
    {
        if ($value) {
            return true;
        }

        $display_message = trim($display_message);
        $message_to_log  = trim($message_to_log);

        if (empty($message_to_log)) {
            $message_to_log = $display_message;
        }

        Log::error($message_to_log, $message_data);

        echo $display_message;

        exit;
    }

    public static function json_assert($value, $display_message, $message_to_log = '', $message_data = [])
    {
        if ($value) {
            return true;
        }

        $display_message = trim($display_message);
        $message_to_log  = trim($message_to_log);

        if (empty($message_to_log)) {
            $message_to_log = $display_message;
        }

        Log::error($message_to_log, $message_data);

        header('Content-Type: application/json');

        echo json_encode(['success' => false, 'error' => $display_message]);

        exit;
    }

} 