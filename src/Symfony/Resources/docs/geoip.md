Geolocalization
===============

The UAMADdressBundle now includes MaxMind's geoip bundle.

Local testing
-------------

When testing on a local server, i.e. a server run on your own personal computer, the client IP address
is likely ot be 127.0.0.1. This makes the geolocalization feature untestable.

To circumvent this issue, the bundle defines `default_local_id` configuration setting, where you can set an arbitrary IP address.

If set, this setting's value will be as the client IP address in the address form.

You can set to be the IP address of your computer, if ou are connected directly to the internet, or the IP address of your internet router.

You can also set it to any arbitrary IP address for testing purposes.

Make sure this setting is not set in the produciton environment.
