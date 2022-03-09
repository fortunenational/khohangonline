<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v8/services/feed_item_service.proto

namespace GPBMetadata\Google\Ads\GoogleAds\V8\Services;

class FeedItemService
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();
        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Http::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        \GPBMetadata\Google\Protobuf\Any::initOnce();
        \GPBMetadata\Google\Rpc\Status::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
:google/ads/googleads/v8/enums/policy_approval_status.protogoogle.ads.googleads.v8.enums"�
PolicyApprovalStatusEnum"�
PolicyApprovalStatus
UNSPECIFIED 
UNKNOWN
DISAPPROVED
APPROVED_LIMITED
APPROVED
AREA_OF_INTEREST_ONLYB�
!com.google.ads.googleads.v8.enumsBPolicyApprovalStatusProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
8google/ads/googleads/v8/enums/policy_review_status.protogoogle.ads.googleads.v8.enums"�
PolicyReviewStatusEnum"�
PolicyReviewStatus
UNSPECIFIED 
UNKNOWN
REVIEW_IN_PROGRESS
REVIEWED
UNDER_APPEAL
ELIGIBLE_MAY_SERVEB�
!com.google.ads.googleads.v8.enumsBPolicyReviewStatusProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
;google/ads/googleads/v8/enums/policy_topic_entry_type.protogoogle.ads.googleads.v8.enums"�
PolicyTopicEntryTypeEnum"�
PolicyTopicEntryType
UNSPECIFIED 
UNKNOWN

PROHIBITED
LIMITED
FULLY_LIMITED
DESCRIPTIVE

BROADENING
AREA_OF_INTEREST_ONLYB�
!com.google.ads.googleads.v8.enumsBPolicyTopicEntryTypeProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
Wgoogle/ads/googleads/v8/enums/policy_topic_evidence_destination_mismatch_url_type.protogoogle.ads.googleads.v8.enums"�
1PolicyTopicEvidenceDestinationMismatchUrlTypeEnum"�
-PolicyTopicEvidenceDestinationMismatchUrlType
UNSPECIFIED 
UNKNOWN
DISPLAY_URL
	FINAL_URL
FINAL_MOBILE_URL
TRACKING_URL
MOBILE_TRACKING_URLB�
!com.google.ads.googleads.v8.enumsB2PolicyTopicEvidenceDestinationMismatchUrlTypeProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
Xgoogle/ads/googleads/v8/enums/policy_topic_evidence_destination_not_working_device.protogoogle.ads.googleads.v8.enums"�
2PolicyTopicEvidenceDestinationNotWorkingDeviceEnum"q
.PolicyTopicEvidenceDestinationNotWorkingDevice
UNSPECIFIED 
UNKNOWN
DESKTOP
ANDROID
IOSB�
!com.google.ads.googleads.v8.enumsB3PolicyTopicEvidenceDestinationNotWorkingDeviceProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
`google/ads/googleads/v8/enums/policy_topic_evidence_destination_not_working_dns_error_type.protogoogle.ads.googleads.v8.enums"�
8PolicyTopicEvidenceDestinationNotWorkingDnsErrorTypeEnum"�
4PolicyTopicEvidenceDestinationNotWorkingDnsErrorType
UNSPECIFIED 
UNKNOWN
HOSTNAME_NOT_FOUND
GOOGLE_CRAWLER_DNS_ISSUEB�
!com.google.ads.googleads.v8.enumsB9PolicyTopicEvidenceDestinationNotWorkingDnsErrorTypeProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
+google/ads/googleads/v8/common/policy.protogoogle.ads.googleads.v8.commonWgoogle/ads/googleads/v8/enums/policy_topic_evidence_destination_mismatch_url_type.protoXgoogle/ads/googleads/v8/enums/policy_topic_evidence_destination_not_working_device.proto`google/ads/googleads/v8/enums/policy_topic_evidence_destination_not_working_dns_error_type.protogoogle/api/annotations.proto"n
PolicyViolationKey
policy_name (	H �
violating_text (	H�B
_policy_nameB
_violating_text"�
PolicyValidationParameter
ignorable_policy_topics (	X
exempt_policy_violation_keys (22.google.ads.googleads.v8.common.PolicyViolationKey"�
PolicyTopicEntry
topic (	H �Z
type (2L.google.ads.googleads.v8.enums.PolicyTopicEntryTypeEnum.PolicyTopicEntryTypeF
	evidences (23.google.ads.googleads.v8.common.PolicyTopicEvidenceJ
constraints (25.google.ads.googleads.v8.common.PolicyTopicConstraintB
_topic"�

PolicyTopicEvidenceW
website_list (2?.google.ads.googleads.v8.common.PolicyTopicEvidence.WebsiteListH Q
	text_list (2<.google.ads.googleads.v8.common.PolicyTopicEvidence.TextListH 
language_code	 (	H h
destination_text_list (2G.google.ads.googleads.v8.common.PolicyTopicEvidence.DestinationTextListH g
destination_mismatch (2G.google.ads.googleads.v8.common.PolicyTopicEvidence.DestinationMismatchH l
destination_not_working (2I.google.ads.googleads.v8.common.PolicyTopicEvidence.DestinationNotWorkingH 
TextList
texts (	
WebsiteList
websites (	0
DestinationTextList
destination_texts (	�
DestinationMismatch�
	url_types (2~.google.ads.googleads.v8.enums.PolicyTopicEvidenceDestinationMismatchUrlTypeEnum.PolicyTopicEvidenceDestinationMismatchUrlType�
DestinationNotWorking
expanded_url (	H��
device (2�.google.ads.googleads.v8.enums.PolicyTopicEvidenceDestinationNotWorkingDeviceEnum.PolicyTopicEvidenceDestinationNotWorkingDevice#
last_checked_date_time (	H��
dns_error_type (2�.google.ads.googleads.v8.enums.PolicyTopicEvidenceDestinationNotWorkingDnsErrorTypeEnum.PolicyTopicEvidenceDestinationNotWorkingDnsErrorTypeH 
http_error_code (H B
reasonB
_expanded_urlB
_last_checked_date_timeB
value"�
PolicyTopicConstraintn
country_constraint_list (2K.google.ads.googleads.v8.common.PolicyTopicConstraint.CountryConstraintListH g
reseller_constraint (2H.google.ads.googleads.v8.common.PolicyTopicConstraint.ResellerConstraintH z
#certificate_missing_in_country_list (2K.google.ads.googleads.v8.common.PolicyTopicConstraint.CountryConstraintListH �
+certificate_domain_mismatch_in_country_list (2K.google.ads.googleads.v8.common.PolicyTopicConstraint.CountryConstraintListH �
CountryConstraintList%
total_targeted_countries (H �Z
	countries (2G.google.ads.googleads.v8.common.PolicyTopicConstraint.CountryConstraintB
_total_targeted_countries
ResellerConstraintI
CountryConstraint
country_criterion (	H �B
_country_criterionB
valueB�
"com.google.ads.googleads.v8.commonBPolicyProtoPZDgoogle.golang.org/genproto/googleapis/ads/googleads/v8/common;common�GAA�Google.Ads.GoogleAds.V8.Common�Google\\Ads\\GoogleAds\\V8\\Common�"Google::Ads::GoogleAds::V8::Commonbproto3
�
5google/ads/googleads/v8/common/custom_parameter.protogoogle.ads.googleads.v8.common"I
CustomParameter
key (	H �
value (	H�B
_keyB
_valueB�
"com.google.ads.googleads.v8.commonBCustomParameterProtoPZDgoogle.golang.org/genproto/googleapis/ads/googleads/v8/common;common�GAA�Google.Ads.GoogleAds.V8.Common�Google\\Ads\\GoogleAds\\V8\\Common�"Google::Ads::GoogleAds::V8::Commonbproto3
�
0google/ads/googleads/v8/common/feed_common.protogoogle.ads.googleads.v8.common"c
Money
currency_code (	H �
amount_micros (H�B
_currency_codeB
_amount_microsB�
"com.google.ads.googleads.v8.commonBFeedCommonProtoPZDgoogle.golang.org/genproto/googleapis/ads/googleads/v8/common;common�GAA�Google.Ads.GoogleAds.V8.Common�Google\\Ads\\GoogleAds\\V8\\Common�"Google::Ads::GoogleAds::V8::Commonbproto3
�
4google/ads/googleads/v8/enums/placeholder_type.protogoogle.ads.googleads.v8.enums"�
PlaceholderTypeEnum"�
PlaceholderType
UNSPECIFIED 
UNKNOWN
SITELINK
CALL
APP
LOCATION
AFFILIATE_LOCATION
CALLOUT
STRUCTURED_SNIPPET
MESSAGE		
PRICE

	PROMOTION
AD_CUSTOMIZER
DYNAMIC_EDUCATION
DYNAMIC_FLIGHT
DYNAMIC_CUSTOM
DYNAMIC_HOTEL
DYNAMIC_REAL_ESTATE
DYNAMIC_TRAVEL
DYNAMIC_LOCAL
DYNAMIC_JOB	
IMAGEB�
!com.google.ads.googleads.v8.enumsBPlaceholderTypeProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
Egoogle/ads/googleads/v8/enums/feed_item_quality_approval_status.protogoogle.ads.googleads.v8.enums"�
!FeedItemQualityApprovalStatusEnum"\\
FeedItemQualityApprovalStatus
UNSPECIFIED 
UNKNOWN
APPROVED
DISAPPROVEDB�
!com.google.ads.googleads.v8.enumsB"FeedItemQualityApprovalStatusProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�	
Hgoogle/ads/googleads/v8/enums/feed_item_quality_disapproval_reason.protogoogle.ads.googleads.v8.enums"�
$FeedItemQualityDisapprovalReasonEnum"�
 FeedItemQualityDisapprovalReason
UNSPECIFIED 
UNKNOWN"
PRICE_TABLE_REPETITIVE_HEADERS&
"PRICE_TABLE_REPETITIVE_DESCRIPTION!
PRICE_TABLE_INCONSISTENT_ROWS*
&PRICE_DESCRIPTION_HAS_PRICE_QUALIFIERS
PRICE_UNSUPPORTED_LANGUAGE.
*PRICE_TABLE_ROW_HEADER_TABLE_TYPE_MISMATCH/
+PRICE_TABLE_ROW_HEADER_HAS_PROMOTIONAL_TEXT,
(PRICE_TABLE_ROW_DESCRIPTION_NOT_RELEVANT	4
0PRICE_TABLE_ROW_DESCRIPTION_HAS_PROMOTIONAL_TEXT
1
-PRICE_TABLE_ROW_HEADER_DESCRIPTION_REPETITIVE
PRICE_TABLE_ROW_UNRATEABLE!
PRICE_TABLE_ROW_PRICE_INVALID
PRICE_TABLE_ROW_URL_INVALID)
%PRICE_HEADER_OR_DESCRIPTION_HAS_PRICE.
*STRUCTURED_SNIPPETS_HEADER_POLICY_VIOLATED\'
#STRUCTURED_SNIPPETS_REPEATED_VALUES,
(STRUCTURED_SNIPPETS_EDITORIAL_GUIDELINES,
(STRUCTURED_SNIPPETS_HAS_PROMOTIONAL_TEXTB�
!com.google.ads.googleads.v8.enumsB%FeedItemQualityDisapprovalReasonProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
4google/ads/googleads/v8/enums/feed_item_status.protogoogle.ads.googleads.v8.enums"^
FeedItemStatusEnum"H
FeedItemStatus
UNSPECIFIED 
UNKNOWN
ENABLED
REMOVEDB�
!com.google.ads.googleads.v8.enumsBFeedItemStatusProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
?google/ads/googleads/v8/enums/feed_item_validation_status.protogoogle.ads.googleads.v8.enums"}
FeedItemValidationStatusEnum"]
FeedItemValidationStatus
UNSPECIFIED 
UNKNOWN
PENDING
INVALID	
VALIDB�
!com.google.ads.googleads.v8.enumsBFeedItemValidationStatusProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
=google/ads/googleads/v8/enums/geo_targeting_restriction.protogoogle.ads.googleads.v8.enums"p
GeoTargetingRestrictionEnum"Q
GeoTargetingRestriction
UNSPECIFIED 
UNKNOWN
LOCATION_OF_PRESENCEB�
!com.google.ads.googleads.v8.enumsBGeoTargetingRestrictionProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
9google/ads/googleads/v8/enums/response_content_type.protogoogle.ads.googleads.v8.enums"o
ResponseContentTypeEnum"T
ResponseContentType
UNSPECIFIED 
RESOURCE_NAME_ONLY
MUTABLE_RESOURCEB�
!com.google.ads.googleads.v8.enumsBResponseContentTypeProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v8/enums;enums�GAA�Google.Ads.GoogleAds.V8.Enums�Google\\Ads\\GoogleAds\\V8\\Enums�!Google::Ads::GoogleAds::V8::Enumsbproto3
�
?google/ads/googleads/v8/errors/feed_item_validation_error.protogoogle.ads.googleads.v8.errors"�
FeedItemValidationErrorEnum"�
FeedItemValidationError
UNSPECIFIED 
UNKNOWN
STRING_TOO_SHORT
STRING_TOO_LONG
VALUE_NOT_SPECIFIED(
$INVALID_DOMESTIC_PHONE_NUMBER_FORMAT
INVALID_PHONE_NUMBER*
&PHONE_NUMBER_NOT_SUPPORTED_FOR_COUNTRY#
PREMIUM_RATE_NUMBER_NOT_ALLOWED
DISALLOWED_NUMBER_TYPE	
VALUE_OUT_OF_RANGE
*
&CALLTRACKING_NOT_SUPPORTED_FOR_COUNTRY.
*CUSTOMER_NOT_IN_ALLOWLIST_FOR_CALLTRACKINGc
INVALID_COUNTRY_CODE
INVALID_APP_ID!
MISSING_ATTRIBUTES_FOR_FIELDS
INVALID_TYPE_ID
INVALID_EMAIL_ADDRESS
INVALID_HTTPS_URL
MISSING_DELIVERY_ADDRESS
START_DATE_AFTER_END_DATE 
MISSING_FEED_ITEM_START_TIME
MISSING_FEED_ITEM_END_TIME
MISSING_FEED_ITEM_ID#
VANITY_PHONE_NUMBER_NOT_ALLOWED$
 INVALID_REVIEW_EXTENSION_SNIPPET
INVALID_NUMBER_FORMAT
INVALID_DATE_FORMAT
INVALID_PRICE_FORMAT
UNKNOWN_PLACEHOLDER_FIELD.
*MISSING_ENHANCED_SITELINK_DESCRIPTION_LINE&
"REVIEW_EXTENSION_SOURCE_INELIGIBLE\'
#HYPHENS_IN_REVIEW_EXTENSION_SNIPPET -
)DOUBLE_QUOTES_IN_REVIEW_EXTENSION_SNIPPET!&
"QUOTES_IN_REVIEW_EXTENSION_SNIPPET"
INVALID_FORM_ENCODED_PARAMS#
INVALID_URL_PARAMETER_NAME$
NO_GEOCODING_RESULT%(
$SOURCE_NAME_IN_REVIEW_EXTENSION_TEXT&-
)CARRIER_SPECIFIC_SHORT_NUMBER_NOT_ALLOWED\' 
INVALID_PLACEHOLDER_FIELD_ID(
INVALID_URL_TAG)
LIST_TOO_LONG*"
INVALID_ATTRIBUTES_COMBINATION+
DUPLICATE_VALUES,%
!INVALID_CALL_CONVERSION_ACTION_ID-!
CANNOT_SET_WITHOUT_FINAL_URLS.$
 APP_ID_DOESNT_EXIST_IN_APP_STORE/
INVALID_FINAL_URL0
INVALID_TRACKING_URL1*
&INVALID_FINAL_URL_FOR_APP_DOWNLOAD_URL2
LIST_TOO_SHORT3
INVALID_USER_ACTION4
INVALID_TYPE_NAME5
INVALID_EVENT_CHANGE_STATUS6
INVALID_SNIPPETS_HEADER7
INVALID_ANDROID_APP_LINK8;
7NUMBER_TYPE_WITH_CALLTRACKING_NOT_SUPPORTED_FOR_COUNTRY9
RESERVED_KEYWORD_OTHER:
DUPLICATE_OPTION_LABELS;
DUPLICATE_OPTION_PREFILLS<
UNEQUAL_LIST_LENGTHS=
INCONSISTENT_CURRENCY_CODES>*
&PRICE_EXTENSION_HAS_DUPLICATED_HEADERS?.
*ITEM_HAS_DUPLICATED_HEADER_AND_DESCRIPTION@%
!PRICE_EXTENSION_HAS_TOO_FEW_ITEMSA
UNSUPPORTED_VALUEB
INVALID_FINAL_MOBILE_URLC%
!INVALID_KEYWORDLESS_AD_RULE_LABELD\'
#VALUE_TRACK_PARAMETER_NOT_SUPPORTEDE*
&UNSUPPORTED_VALUE_IN_SELECTED_LANGUAGEF
INVALID_IOS_APP_LINKG,
(MISSING_IOS_APP_LINK_OR_IOS_APP_STORE_IDH
PROMOTION_INVALID_TIMEI9
5PROMOTION_CANNOT_SET_PERCENT_OFF_AND_MONEY_AMOUNT_OFFJ>
:PROMOTION_CANNOT_SET_PROMOTION_CODE_AND_ORDERS_OVER_AMOUNTK%
!TOO_MANY_DECIMAL_PLACES_SPECIFIEDL
AD_CUSTOMIZERS_NOT_ALLOWEDM
INVALID_LANGUAGE_CODEN
UNSUPPORTED_LANGUAGEO
IF_FUNCTION_NOT_ALLOWEDP
INVALID_FINAL_URL_SUFFIXQ#
INVALID_TAG_IN_FINAL_URL_SUFFIXR#
INVALID_FINAL_URL_SUFFIX_FORMATS0
,CUSTOMER_CONSENT_FOR_CALL_RECORDING_REQUIREDT\'
#ONLY_ONE_DELIVERY_OPTION_IS_ALLOWEDU
NO_DELIVERY_OPTION_IS_SETV&
"INVALID_CONVERSION_REPORTING_STATEW
IMAGE_SIZE_WRONGX+
\'EMAIL_DELIVERY_NOT_AVAILABLE_IN_COUNTRYY\'
#AUTO_REPLY_NOT_AVAILABLE_IN_COUNTRYZ
INVALID_LATITUDE_VALUE[
INVALID_LONGITUDE_VALUE\\
TOO_MANY_LABELS]
INVALID_IMAGE_URL^
MISSING_LATITUDE_VALUE_
MISSING_LONGITUDE_VALUE`
ADDRESS_NOT_FOUNDa
ADDRESS_NOT_TARGETABLEb
INVALID_ASSET_IDd
INCOMPATIBLE_ASSET_TYPEe
IMAGE_ERROR_UNEXPECTED_SIZEf(
$IMAGE_ERROR_ASPECT_RATIO_NOT_ALLOWEDg
IMAGE_ERROR_FILE_TOO_LARGEh"
IMAGE_ERROR_FORMAT_NOT_ALLOWEDi$
 IMAGE_ERROR_CONSTRAINTS_VIOLATEDj
IMAGE_ERROR_SERVER_ERRORkB�
"com.google.ads.googleads.v8.errorsBFeedItemValidationErrorProtoPZDgoogle.golang.org/genproto/googleapis/ads/googleads/v8/errors;errors�GAA�Google.Ads.GoogleAds.V8.Errors�Google\\Ads\\GoogleAds\\V8\\Errors�"Google::Ads::GoogleAds::V8::Errorsbproto3
�
1google/ads/googleads/v8/resources/feed_item.proto!google.ads.googleads.v8.resources0google/ads/googleads/v8/common/feed_common.proto+google/ads/googleads/v8/common/policy.protoEgoogle/ads/googleads/v8/enums/feed_item_quality_approval_status.protoHgoogle/ads/googleads/v8/enums/feed_item_quality_disapproval_reason.proto4google/ads/googleads/v8/enums/feed_item_status.proto?google/ads/googleads/v8/enums/feed_item_validation_status.proto=google/ads/googleads/v8/enums/geo_targeting_restriction.proto4google/ads/googleads/v8/enums/placeholder_type.proto:google/ads/googleads/v8/enums/policy_approval_status.proto8google/ads/googleads/v8/enums/policy_review_status.proto?google/ads/googleads/v8/errors/feed_item_validation_error.protogoogle/api/field_behavior.protogoogle/api/resource.protogoogle/api/annotations.proto"�
FeedItem@
resource_name (	B)�A�A#
!googleads.googleapis.com/FeedItem8
feed (	B%�A�A
googleads.googleapis.com/FeedH �
id (B�AH�
start_date_time (	H�
end_date_time (	H�S
attribute_values (29.google.ads.googleads.v8.resources.FeedItemAttributeValueu
geo_targeting_restriction (2R.google.ads.googleads.v8.enums.GeoTargetingRestrictionEnum.GeoTargetingRestrictionN
url_custom_parameters (2/.google.ads.googleads.v8.common.CustomParameterU
status	 (2@.google.ads.googleads.v8.enums.FeedItemStatusEnum.FeedItemStatusB�A[
policy_infos
 (2@.google.ads.googleads.v8.resources.FeedItemPlaceholderPolicyInfoB�A:b�A_
!googleads.googleapis.com/FeedItem:customers/{customer_id}/feedItems/{feed_id}~{feed_item_id}B
_feedB
_idB
_start_date_timeB
_end_date_time"�
FeedItemAttributeValue
feed_attribute_id (H �
integer_value (H�
boolean_value (H�
string_value (	H�
double_value (H�:
price_value (2%.google.ads.googleads.v8.common.Money
integer_values (
boolean_values (
string_values (	
double_values (B
_feed_attribute_idB
_integer_valueB
_boolean_valueB
_string_valueB
_double_value"�
FeedItemPlaceholderPolicyInfof
placeholder_type_enum
 (2B.google.ads.googleads.v8.enums.PlaceholderTypeEnum.PlaceholderTypeB�A,
feed_mapping_resource_name (	B�AH �d
review_status (2H.google.ads.googleads.v8.enums.PolicyReviewStatusEnum.PolicyReviewStatusB�Aj
approval_status (2L.google.ads.googleads.v8.enums.PolicyApprovalStatusEnum.PolicyApprovalStatusB�AS
policy_topic_entries (20.google.ads.googleads.v8.common.PolicyTopicEntryB�At
validation_status (2T.google.ads.googleads.v8.enums.FeedItemValidationStatusEnum.FeedItemValidationStatusB�AZ
validation_errors (2:.google.ads.googleads.v8.resources.FeedItemValidationErrorB�A�
quality_approval_status (2^.google.ads.googleads.v8.enums.FeedItemQualityApprovalStatusEnum.FeedItemQualityApprovalStatusB�A�
quality_disapproval_reasons	 (2d.google.ads.googleads.v8.enums.FeedItemQualityDisapprovalReasonEnum.FeedItemQualityDisapprovalReasonB�AB
_feed_mapping_resource_name"�
FeedItemValidationErrorr
validation_error (2S.google.ads.googleads.v8.errors.FeedItemValidationErrorEnum.FeedItemValidationErrorB�A
description (	B�AH �
feed_attribute_ids (B�A

extra_info (	B�AH�B
_descriptionB
_extra_infoB�
%com.google.ads.googleads.v8.resourcesBFeedItemProtoPZJgoogle.golang.org/genproto/googleapis/ads/googleads/v8/resources;resources�GAA�!Google.Ads.GoogleAds.V8.Resources�!Google\\Ads\\GoogleAds\\V8\\Resources�%Google::Ads::GoogleAds::V8::Resourcesbproto3
�
8google/ads/googleads/v8/services/feed_item_service.proto google.ads.googleads.v8.services1google/ads/googleads/v8/resources/feed_item.protogoogle/api/annotations.protogoogle/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto google/protobuf/field_mask.protogoogle/rpc/status.proto"V
GetFeedItemRequest@
resource_name (	B)�A�A#
!googleads.googleapis.com/FeedItem"�
MutateFeedItemsRequest
customer_id (	B�AL

operations (23.google.ads.googleads.v8.services.FeedItemOperationB�A
partial_failure (
validate_only (i
response_content_type (2J.google.ads.googleads.v8.enums.ResponseContentTypeEnum.ResponseContentType"�
FeedItemOperation/
update_mask (2.google.protobuf.FieldMask=
create (2+.google.ads.googleads.v8.resources.FeedItemH =
update (2+.google.ads.googleads.v8.resources.FeedItemH 
remove (	H B
	operation"�
MutateFeedItemsResponse1
partial_failure_error (2.google.rpc.StatusG
results (26.google.ads.googleads.v8.services.MutateFeedItemResult"m
MutateFeedItemResult
resource_name (	>
	feed_item (2+.google.ads.googleads.v8.resources.FeedItem2�
FeedItemService�
GetFeedItem4.google.ads.googleads.v8.services.GetFeedItemRequest+.google.ads.googleads.v8.resources.FeedItem"C���-+/v8/{resource_name=customers/*/feedItems/*}�Aresource_name�
MutateFeedItems8.google.ads.googleads.v8.services.MutateFeedItemsRequest9.google.ads.googleads.v8.services.MutateFeedItemsResponse"R���3"./v8/customers/{customer_id=*}/feedItems:mutate:*�Acustomer_id,operationsE�Agoogleads.googleapis.com�A\'https://www.googleapis.com/auth/adwordsB�
$com.google.ads.googleads.v8.servicesBFeedItemServiceProtoPZHgoogle.golang.org/genproto/googleapis/ads/googleads/v8/services;services�GAA� Google.Ads.GoogleAds.V8.Services� Google\\Ads\\GoogleAds\\V8\\Services�$Google::Ads::GoogleAds::V8::Servicesbproto3'
        , true);
        static::$is_initialized = true;
    }
}

