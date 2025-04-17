<?php

$t = array(
    '0' => ' OK', //           Trx_OK
    '-10' => 'No XCX file', //           Trx_NoFile
    '-15' => 'Failed to save XCX file', //           Trx_FileSaveErr
    '-20' => 'No connection', //           Trx_NotConn
    '-25' => 'Disconnected', //           Trx_Disconnect
    '-30' => 'Connection broken', //           Trx_BreakConn
    '-35' => 'Connection established with unknown device', //           Trx_NotEthm
    '-40' => 'Control panel busy', //           Trx_Busy
    '-50' => 'No service for DLOADX', //           Trx_NotCA4Dx
    '-60' => 'Control panel not ready', //           Trx_NotReady
    '-70' => 'Try to connect again', //           Trx_TryAgain
    '-80' => 'Encrypted data', //           Trx_Unreadable
    '-90' => 'Unknown version of ETHM-1', //           Trx_ETHVerUnkn
    '-100' => 'Inconsistent computer identifier', //           Trx_PcBadID
    '-110' => 'Inconsistent control panel identifier', //           Trx_CaBadID
    '-120' => 'No confirmation of connection start', //           Trx_NotST
    '-130' => 'Control panel does not recognize commands', //           Trx_RxNG
    '-140' => 'Unsupported control panel type', //           Trx_BadCAX
    '-150' => 'Unsupported control panel version', //           Trx_BadVER
    '-160' => 'Inconsistent control panel version', //           Trx_DifrVER
    '-170' => 'No data       disconnected', //           Trx_TCPNoData
    '-180' => 'Failed to read data from control panel', //           Trx_RDerr
    '-11' => 'Failed to read events from control panel', //           Trx_RDEverr
    '-182' => 'Failed to read from modules', //           Trx_PIPOerr
    '-210' => 'No connection with database', //           Trx_BaseNotCon
    '-220' => 'No system ID in database', //           Trx_IdNotInBase
    '-230' => 'Failed to create temporary file', //           Trx_TMPfileErr
    '-240' => 'Failed to save XCX file', //           Trx_XCXnotCreated
    '-250' => 'Failed to create communication process', //           Trx_DxRWCreateErr
    '-260' => 'Communication process max. time exceeded.', //           Trx_DxRWForceStop
    '-270' => 'Failed to save data to database', //           Trx_DxRWDBsaveCAerr
    '-280' => 'Failed to save events to database', //           Trx_DxRWDBsaveEVerr
    '-290' => 'Failed to save data and events to database', //           Trx_DxRWDBsaveCAEVerr
    '-300' => 'Failed to download data from database', //           Trx_DBdataGetErr
    '-1000' => 'Data imported to database', //           Trx_Import
    '-1010' => 'New system created in database', //           Trx_New
    '-1020' => 'System data and events deleted from database', //          Trx_Delete
);

return $t;
