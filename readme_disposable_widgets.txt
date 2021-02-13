# Disposable Widgets For PhpVms v7

Some widgets to enhance your site's look and functionality, prepared for personal use of course according to my needs.

***** Installation Steps

If you have a default installation of phpvms, just unzip the package at the root of your phpvms installation, if not please follow below steps;

Upload files in app\Widgets folder to your phpvms app/Widgets folder
Upload files in resources\views\layouts\default\widgets folder to your templates widgets folder (exp. */resources/views/layouts/mydefault/widgets*)

***** Usage

Call the widgets anywhere you want like you call/load others

{{ Widget::TopPilots(['count' => 10, 'type' => 'time']) }}
{{ Widget::TopPilotsByPeriod(['count' => 15, 'type' => 'distance', 'period' => 'currenty']) }}
{{ Widget::TopAirports(['count' => 5, 'type' => 'dep']) }}
{{ Widget::AirlineStats() }}
{{ Widget::PersonalStats(['disp' => 'full', 'user' => $user->id, 'type' => 'avglanding', 'period' => 15]) }}
{{ Widget::AircraftStats(['type' => 'location']) }}
{{ Widget::AirportAircrafts(['location' => $airport->icao]) }}
{{ Widget::AirportPireps(['location' => $airport->icao]) }}
{{ Widget::FlightTimeMultiplier() }}

***** Options: TopPilots

For TopPilots there are two main options.They are count and type;

count can be any number you want (except 0 of course)
type can be flights, time or distance

['count' => 5, 'type' => 'flights']
['count' => 10, 'type' => 'time']
['count' => 8, 'type' => 'distance']

By default (without any options set) widget will report top 3 pilots by their flight counts

***** Options: TopPilotsByPeriod

For TopPilotsByPeriod there are three main options.They are count, type and period;

count can be any number you want (except 0 of course)
type can be flights, time or distance
period can be currentm, lastm, prevm, currenty or lasty

['count' => 5, 'type' => 'flights', 'period' => 'currentm']
['count' => 10, 'type' => 'time', 'period' => 'prevm']
['count' => 1, 'type' => 'distance', 'period' => 'lasty']

By default (without any options set) widget will report top 3 pilots by flight counts of current month.
If you want to see your "Best" pilot, just set the count to 1

***** Options: TopAirports

For TopAirports there are two options.They are count and type;

count can be any number you want (except 0 of course)
type can be dep or arr

['count' => 8, 'type' => 'dep']
['count' => 5, 'type' => 'arr']

By default (without any options set) widget will report top 3 airports by departure counts

***** Options: AirlineStats

This widget has only one option called airline and it displays either your total system stats or stats for the airline choosed.

airline can be any airline's id number

['airline' => 3] or
['airline' => {{ $user->airline->id }}] *or*
['airline' => {{ $flight->airline->id }}] *this depends how and where you want to use the widget*

By default (without no option input) widget will display overall stats of your phpvms installation.

***** Options : PersonalStats

For PersonalStats there are four main options which are user, disp, type and period;

user can be any user's id or not used at all
period can be any number of days (except 0 of course), currentm, lastm, prevm, currenty, lasty or not used at all
disp can be full or not used at all
type can be avglanding, avgscore, avgtime, tottime, avgdistance, totdistance, avgfuel, totfuel, totflight

If no user is defined, widget get current user's data for calculations. This may be used for dashboard or any personal pages where the viewer will be able to see his results. If you want to put some stats on the user's profile page then you need to define the user otherwise every visitor will see their stats :)
*(['user' => $user->id] is enough to get proper results at user profile page)*

If no period is defined then all accepted reports will be used for calculations, else you will get the result for the last *n* days you provided like Average Landing Rate for flights done in last 15 days
*(['period' => 7] will give you the last 7 days)*

If you want to have a full card with the result and the info text then use *'disp' => full*, while calling the widget. It should be compatible with the default template and stisla but if you need you can customize the look in the *personalstats.blade* file.
Also if you are not using English then you can define the text in your own language in the same file.

['disp' => 'full', 'user' => $user->id, 'type' => 'totfuel', 'period' => 'lastm'] : Total Fuel Spent During Last Month
['disp' => 'full', 'user' => $user->id, 'type' => 'avglanding'] : Average Landing Rate displayed in a card
['user' => $user->id, 'type' => 'totdistance', 'period' => 7] : Plain text total distance in last 7 days
['user' => $user->id, 'type' => 'totflight', 'period' => 3] : Plain text number of flights in last 3 days 

By default (without any options set) widget will provide average landing rate without any html styling considering the viewer's pireps.

***** Options : AircraftStats

This widget has only one option called *type* and it displays either your aircraft count according to their locations or a count according the their ICAO type codes.

type can be location or icao

['type' => 'icao']
['type' => 'location']

By default (without any option input) widget will display aircraft counts per airport

***** Options : AirportAircrafts

This widget has only one option called *location* and it displays your aircrafts at given location.

location *must* be an airport_id (4 letter ICAO code)

['location' => 'LTCG'] or
['location' => $airport->icao] if you are going to use it in Airports page
['location' => $flight->dpt_airport_id] if you are going to use it in Bids or Flight Details page

By default (without any option input) widget will not display any aircrafts as expected

***** Options : AirportPireps

This widget has only one option called *location* and it displays pireps for given location.

location *must* be an airport_id (4 letter ICAO code)

['location' => 'LTAI'] or
['location' => $airport->icao] if you are going to use it in Airports page
['location' => $flight->dpt_airport_id] if you are going to use it in Bids or Flight Details page

By default (without any option input) widget will not display any pireps as expected

***** Options: FlightTimeMultiplier

No options for this, it is just a javascript calculator. Enter hours, minutes and the multiplier to get the result.Some VA's or platforms offer double or multiplied hours for some tours and events, thus this may come in handy.

Widget may be placed anywhere you wish, best possible location is your pirep fields.blade, just below or above submit/edit buttons.

*****

Safe flights and enjoy.
B.Fatih KOZ
'Disposable Hero'
https://github.com/FatihKoz
13.FEB.21
