export function apiErrorHandler(error) {
    let message = 'An error occurred while making a request to the API';

    if (error.response) {
        switch (Math.floor(error.response.status / 100)) {
            case 4:
                message = 'There was an issue with the request. Please check your inputs and try again.';
                break;
            case 5:
                message = 'Looks like we\'re having some server issues. Please try again later.';
                break;
            default:
                message = 'Something went wrong with your request. Please try again.';
                break;
        }
    } else if (error.request) {
        message = 'There was a problem communicating with the server. Please check your network connection and try again.';
    } else {
        message = 'A problem occurred while setting up the request. Please try again.';
    }

    return message;
}
