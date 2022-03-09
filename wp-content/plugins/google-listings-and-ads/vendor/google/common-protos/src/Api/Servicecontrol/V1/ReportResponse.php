<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/servicecontrol/v1/service_controller.proto

namespace Google\Api\Servicecontrol\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response message for the Report method.
 *
 * Generated from protobuf message <code>google.api.servicecontrol.v1.ReportResponse</code>
 */
class ReportResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Partial failures, one for each `Operation` in the request that failed
     * processing. There are three possible combinations of the RPC status:
     * 1. The combination of a successful RPC status and an empty `report_errors`
     *    list indicates a complete success where all `Operations` in the
     *    request are processed successfully.
     * 2. The combination of a successful RPC status and a non-empty
     *    `report_errors` list indicates a partial success where some
     *    `Operations` in the request succeeded. Each
     *    `Operation` that failed processing has a corresponding item
     *    in this list.
     * 3. A failed RPC status indicates a general non-deterministic failure.
     *    When this happens, it's impossible to know which of the
     *    'Operations' in the request succeeded or failed.
     *
     * Generated from protobuf field <code>repeated .google.api.servicecontrol.v1.ReportResponse.ReportError report_errors = 1;</code>
     */
    private $report_errors;
    /**
     * The actual config id used to process the request.
     *
     * Generated from protobuf field <code>string service_config_id = 2;</code>
     */
    private $service_config_id = '';
    /**
     * The current service rollout id used to process the request.
     *
     * Generated from protobuf field <code>string service_rollout_id = 4;</code>
     */
    private $service_rollout_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Api\Servicecontrol\V1\ReportResponse\ReportError[]|\Google\Protobuf\Internal\RepeatedField $report_errors
     *           Partial failures, one for each `Operation` in the request that failed
     *           processing. There are three possible combinations of the RPC status:
     *           1. The combination of a successful RPC status and an empty `report_errors`
     *              list indicates a complete success where all `Operations` in the
     *              request are processed successfully.
     *           2. The combination of a successful RPC status and a non-empty
     *              `report_errors` list indicates a partial success where some
     *              `Operations` in the request succeeded. Each
     *              `Operation` that failed processing has a corresponding item
     *              in this list.
     *           3. A failed RPC status indicates a general non-deterministic failure.
     *              When this happens, it's impossible to know which of the
     *              'Operations' in the request succeeded or failed.
     *     @type string $service_config_id
     *           The actual config id used to process the request.
     *     @type string $service_rollout_id
     *           The current service rollout id used to process the request.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Api\Servicecontrol\V1\ServiceController::initOnce();
        parent::__construct($data);
    }

    /**
     * Partial failures, one for each `Operation` in the request that failed
     * processing. There are three possible combinations of the RPC status:
     * 1. The combination of a successful RPC status and an empty `report_errors`
     *    list indicates a complete success where all `Operations` in the
     *    request are processed successfully.
     * 2. The combination of a successful RPC status and a non-empty
     *    `report_errors` list indicates a partial success where some
     *    `Operations` in the request succeeded. Each
     *    `Operation` that failed processing has a corresponding item
     *    in this list.
     * 3. A failed RPC status indicates a general non-deterministic failure.
     *    When this happens, it's impossible to know which of the
     *    'Operations' in the request succeeded or failed.
     *
     * Generated from protobuf field <code>repeated .google.api.servicecontrol.v1.ReportResponse.ReportError report_errors = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getReportErrors()
    {
        return $this->report_errors;
    }

    /**
     * Partial failures, one for each `Operation` in the request that failed
     * processing. There are three possible combinations of the RPC status:
     * 1. The combination of a successful RPC status and an empty `report_errors`
     *    list indicates a complete success where all `Operations` in the
     *    request are processed successfully.
     * 2. The combination of a successful RPC status and a non-empty
     *    `report_errors` list indicates a partial success where some
     *    `Operations` in the request succeeded. Each
     *    `Operation` that failed processing has a corresponding item
     *    in this list.
     * 3. A failed RPC status indicates a general non-deterministic failure.
     *    When this happens, it's impossible to know which of the
     *    'Operations' in the request succeeded or failed.
     *
     * Generated from protobuf field <code>repeated .google.api.servicecontrol.v1.ReportResponse.ReportError report_errors = 1;</code>
     * @param \Google\Api\Servicecontrol\V1\ReportResponse\ReportError[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setReportErrors($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Api\Servicecontrol\V1\ReportResponse\ReportError::class);
        $this->report_errors = $arr;

        return $this;
    }

    /**
     * The actual config id used to process the request.
     *
     * Generated from protobuf field <code>string service_config_id = 2;</code>
     * @return string
     */
    public function getServiceConfigId()
    {
        return $this->service_config_id;
    }

    /**
     * The actual config id used to process the request.
     *
     * Generated from protobuf field <code>string service_config_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setServiceConfigId($var)
    {
        GPBUtil::checkString($var, True);
        $this->service_config_id = $var;

        return $this;
    }

    /**
     * The current service rollout id used to process the request.
     *
     * Generated from protobuf field <code>string service_rollout_id = 4;</code>
     * @return string
     */
    public function getServiceRolloutId()
    {
        return $this->service_rollout_id;
    }

    /**
     * The current service rollout id used to process the request.
     *
     * Generated from protobuf field <code>string service_rollout_id = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setServiceRolloutId($var)
    {
        GPBUtil::checkString($var, True);
        $this->service_rollout_id = $var;

        return $this;
    }

}

