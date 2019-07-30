<?php

namespace AM\ManagedMissions\Modules\APIs\ManagedMissions;

class MissionTripsList {

	/**
	 * Property representing the Managed Missions API Url.
	 *
	 * @var string
	 */
	public $apiURL = 'https://app.managedmissions.com/API';

	/**
	 * Property representing the Mission trip purpose code.
	 *
	 * @var int
	 */
	public $purposeCode = 1;

	/**
	 * Property representing the Response Cache Key.
	 *
	 * @var string
	 */
	public $cacheKey = 'ammm_response';

	/**
	 * The MissionTripsList constructor.
	 */
	public function __construct() {
		add_shortcode( 'ammm_trip_list', array( $this, 'renderView' ) );
	}

	/**
	 * Method to get the API URL.
	 *
	 * @return string the API URL.
	 */
	public function getAPIURL() {

		$url = trailingslashit( $this->apiURL );

		return $url;
	}

	/**
	 * Method to get the API call.
	 *
	 * @return string the API call.
	 */
	public function getAPICall() {

		$call = ammm_get_api_call_type();

		return $call;
	}

	/**
	 * Method to get the API key.
	 *
	 * @return string the API key.
	 */
	public function getAPIKey() {

		$key = ammm_get_api_key();

		return $key;
	}

	/**
	 * Method to get the API response parameters.
	 *
	 * @return string the API response parameters.
	 */
	public function getResponseParams() {

		$params = ammm_get_api_query_params();

		return $params;
	}

	/**
	 * Method to get the API endpoint.
	 *
	 * @return string the API endpoint.
	 */
	public function getEndpoint() {

		$url = $this->getAPIURL();
		$call = $this->getAPICall();
		$key = $this->getAPIKey();
		$params = $this->getResponseParams();
		$endpoint = $url . $call . '?apiKey=' . $key . $params;

		return $endpoint;
	}

	/**
	 * Method to get the API response.
	 *
	 * @return WP_Error|array the API response.
	 */
	public function getResponse() {

		$endpoint = $this->getEndpoint();
		$response = wp_remote_get( $endpoint );

		if ( ! is_array( $response ) && is_wp_error( $response ) ) {
			return false;
		}

		return $response;
	}

	/**
	 * Method to get the API response body.
	 *
	 * @return object the API response body.
	 */
	public function getResponseBody() {

		$response = $this->getResponse();
		$body = wp_remote_retrieve_body( $response );

		return $body;
	}

	/**
	 * Method to get the API response body.
	 *
	 * @return array the API response body.
	 */
	public function getResponseJSON() {

		$body = $this->getResponseBody();
		$json = json_decode( $body, true );

		return $json;
	}

	/**
	 * Method to get the API response data.
	 *
	 * @return array the API response data.
	 */
	public function getResponseData() {

		$json = $this->getResponseJSON();
		$data = $json['data'];

		return $data;
	}

	/**
	 * Method to cache the API response.
	 */
	public function cacheResponse() {

		$transient = get_transient( $this->cacheKey );

		if ( ! empty( $transient ) ) {
			return $transient;
		} else {
			$data = $this->getResponseData();
			set_transient( $this->cacheKey, $data, 12 * HOURS_IN_SECONDS );

			return $data;
		}
	}

	/**
	 * Method to return the cached API response.
	 *
	 * @return object returns a JSON object.
	 */
	public function getCachedResponse() {

		$data = get_transient( $this->cacheKey );

		return $data;
	}

	/**
	 * Method to return the trip id.
	 *
	 * @param array $obj the trip object.
	 * @return bool|int the id of the trip or false if conditions are unmet.
	 */
	public function getId( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$id = $obj['Id'];

		return $id;
	}

	/**
	 * Method to return the trip image.
	 *
	 * @param array $obj the trip object.
	 * @return bool|string the trip image or false if conditions are unmet.
	 */
	public function getImage( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$id = $this->getId( $obj );
		$url = 'https://summitrdu.managedmissions.com/Custom/TripImage?tripId=' . $id;

		return $url;
	}

	/**
	 * Method to get the trip title.
	 *
	 * @param array $obj the trip object.
	 * @return bool|string the title of the trip or false if conditions are unmet.
	 */
	public function getTitle( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$title = $obj['TripName'];

		return $title;
	}

	/**
	 * Method to get the trip purpose code.
	 *
	 * @param array $obj the trip object.
	 * @return bool|int the purpose code of the trip or false if conditions are unmet.
	 */
	public function getPurposeCode( $obj ) {

		$code = $obj['PurposeCode'];

		return (int) $code;
	}

	/**
	 * Method to return the trip destination.
	 *
	 * @param array $obj the trip object.
	 * @return bool|int the destination of the trip or false if conditions are unmet.
	 */
	public function getDestination( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$destination = $obj['TripDestination'];

		return $destination;
	}

	/**
	 * Method to return the trip country.
	 *
	 * @param array $obj the trip object.
	 * @return bool|int the country of the trip or false if conditions are unmet.
	 */
	public function getCountry( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$country = $obj['Country'];

		return $country;
	}

	/**
	 * Method to format a date string.
	 *
	 * @param string $date the date to format
	 * @return bool|string returns a formatted date or false if conditions are unmet.
	 */
	public function getFormattedDate( $date ) {

		if ( ! isset( $date ) ) {
			return false;
		}

		$dateStr = preg_match( '/([\d]{10})/', $date, $matches );

		return $matches[0];
	}

	/**
	 * Method to return the year of a date value.
	 *
	 * @param string $date the date value to format.
	 * @return bool|string the date's year or false if conditions are unmet.
	 */
	public function getYear( $date ) {

		if ( ! isset( $date ) ) {
			return false;
		}

		$year = date( 'Y', $date );

		return $year;
	}

	/**
	 * Method to validate the trip year.
	 *
	 * @param string $depDate the trip object.
	 * @return bool|string true/false based on conditions being met.
	 */
	public function _validateYear( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$depYear = $this->getYear( $obj['DepartureDate'] );
		$retYear = $this->getYear( $obj['ReturnDate'] );

		return ( $depYear === $retYear );
	}

	/**
	 * Method to return the trip departure date.
	 *
	 * @param array $obj the trip object.
	 * @return bool|string the departure date of the trip or false if conditions are unmet.
	 */
	public function getDepartureDate( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$format = true === $this->_validateYear( $obj ) ? 'F j' : 'F j, Y';
		$date = $obj['DepartureDate'];
		$dateStr = $this->getFormattedDate( $date );
		$dateStr = date( $format, $dateStr );

		return $dateStr;
	}

	/**
	 * Method to return the trip return date.
	 *
	 * @param array $obj the trip object.
	 * @return bool|string the return date of the trip or false if conditions are unmet.
	 */
	public function getReturnDate( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$date = $obj['ReturnDate'];
		$dateStr = $this->getFormattedDate( $date );
		$dateStr = date( 'F j, Y', $dateStr );

		return $dateStr;
	}

	/**
	 * Method to return the trip dates.
	 *
	 * @param array $obj the trip object.
	 * @return bool|string the trip dates or false if conditions are unmet.
	 */
	public function getDates( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$depDate = $this->getDepartureDate( $obj );
		$retDate = $this->getReturnDate( $obj );
		$dates = $depDate . ' - ' . $retDate;

		return $dates;
	}

	/**
	 * Method to return the trip description.
	 *
	 * @param array $obj the trip object.
	 * @return bool|int the description of the trip or false if conditions are unmet.
	 */
	public function getDescription( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$desc = $obj['TripDescription'];

		return $desc;
	}

	/**
	 * Method to return a concatenated excerpt from the trip description.
	 *
	 * @param string $str the trip description.
	 * @param int $startPos the start position of the excerpt.
	 * @param int $maxLen the max length of the excerpt.
	 * @return bool|string the concatenated excerpt or false if conditions are unmet.
	 */
	public function getExcerpt( $str, $startPos=0, $maxLen=100 ) {

		if ( ! isset( $str ) ) {
			return false;
		}

		if ( strlen( $str ) >= $maxLen ) {
			$excerpt = substr( $str, $startPos, $maxLen-3 );
			$lastSpace = strrpos( $excerpt, ' ' );
			$excerpt = substr( $excerpt, 0, $lastSpace );
			$excerpt .= ' ...';
		} else {
			$excerpt = $str;
		}

		return $excerpt;
	}

	/**
	 * Method to get a single trip.
	 *
	 * @param object $obj the trip object.
	 */
	public function getSingleTrip( $obj ) {

		if ( ! isset( $obj ) ) {
			return false;
		}

		$trip = $obj;
		$country = $this->getCountry( $trip );
		$dates = $this->getDates( $obj );
		$description = $this->getDescription( $trip );
		$destination = isset( $destination ) ? $destination . ', ' . $country : $country;
		$excerpt = $this->getExcerpt( $description, 0, 200 );
		$id = $this->getId( $obj );
		$img = $this->getImage( $trip );
		$title = $this->getTitle( $trip );
		$url = 'https://summitrdu.managedmissions.com/MissionApplication/Start/9468';
		?>
		<div class="mission-trip" data-trip-id="<?php echo esc_attr( $id ); ?>" data-trip-name="<?php echo esc_attr( $title ); ?>">
			<div class="trip-image">
				<img class="image" src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( 'Missions Trip to ' . $destination . ', ' . $country ); ?>">
			</div>
			<div class="trip-content">
				<h3 class="trip-title"><?php echo esc_html( $title ); ?></h3>
				<div class="trip-meta">
					<div class="trip-destination">
						<?php inline_svg( 'map-marker' ); ?>
						<?php echo esc_html( $destination ); ?>
					</div>
					<div class="trip-dates">
						<?php inline_svg( 'calendar' ); ?>
						<?php echo esc_html( $dates ); ?>
					</div>
				</div>
				<div class="trip-description">
					<?php echo esc_html( $excerpt ); ?>
				</div>
				<a class="trip-link" href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( 'Permalink to: Apply to be a part of the Missions Trip to ' . $destination ); ?>"><?php esc_html_e( 'Apply', 'am-managed-missions' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Method to get all trips.
	 *
	 * @param array $data an array of trip data.
	 */
	public function getAllTrips( $data ) {

		$trips = $data;
		$trip = null;

		for ( $i = 0; $i < count( $trips ); $i++ ) {
			$trip = $trips[$i];
			$code = $this->getPurposeCode( $trip );

			if ( 1 === $code ) {
				$this->getSingleTrip( $trip );
			}
		}
	}

	/**
	 * Method to render the titles of all trips with a purpose code of `1`.
	 */
	public function renderView() {

		$trips = $this->cacheResponse();

		ob_start();
		?>
		<div class="mission-trips">
			<?php $this->getAllTrips( $trips ); ?>
		</div>
		<?php
		$output = ob_get_contents();

		ob_get_clean();

		return $output;
	}
}
