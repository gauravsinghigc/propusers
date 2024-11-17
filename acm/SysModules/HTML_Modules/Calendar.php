<?php
function OrganiseDateMonthYear()
{
    // Get the current year and month
    if (isset($_GET['month']) && isset($_GET['year'])) {
        $month = $_GET['month'];
        $year = $_GET['year'];
        $date = $_GET['day'];
    } else {
        $month = date('n');
        $year = date('Y');
        $date = date('d');
    }

    // Get the number of days in the current month
    $numDays = date('t', mktime(0, 0, 0, $month, 1, $year));

    // Get the first day of the month (0 for Sunday, 1 for Monday, etc.)
    $firstDay = date('w', strtotime("$year-$month-01"));

    // Create an array of month names
    $months = array(
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
        7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    );

    // Create links to navigate between months
    $prevMonth = $month - 1;
    $prevYear = $year;
    if ($prevMonth == 0) {
        $prevMonth = 12;
        $prevYear--;
    }
    $nextMonth = $month + 1;
    $nextYear = $year;
    if ($nextMonth == 13) {
        $nextMonth = 1;
        $nextYear++;
    }
    $prevMonthName = $months[$prevMonth];
    $nextMonthName = $months[$nextMonth];

    if (isset($_GET['month'])) {
        $Reset = "<a href='index.php' class='btn btn-xs btn-danger'><i class='fa fa-calendar'></i> Go to Today Date</a> ";
    } else {
        $Reset = "";
    }

    $return = "<div>
                <h4 class='current-date'><i class='fa fa-calendar text-warning'></i> " . $date . " " . $months[$month] . " " . $year . "</h4>
                <h5 class='mb-4'><i class='fa fa-clock text-success'></i> <span id='clock2'>" . date("h:i A") . "</span></h5>
                <p class='flex-s-b m-b-10'>
                <a href='?month=$prevMonth&amp;year=$prevYear&day=$date' class='btn btn-xs btn-default'><i class='fa fa-angle-double-left'></i> $prevMonthName</a> 
                <a href='?month=$nextMonth&amp;year=$nextYear&day=$date' class='btn btn-xs btn-default'>$nextMonthName <i class='fa fa-angle-double-right'></i></a>
                </p>
                <form class='flex-s-b mb-2'>
                <input type='hidden' name='day' value='$date'>
                <select name='month' class='form-control  w-50 m-r-2' onchange='form.submit()'>
                ";
    $return .=  InputOptionsWithKey($months, IfRequested('GET', 'month', $month, false));
    $return .= "
                </select>
                <input type='number' value='" . IfRequested('GET', 'year', date('Y'), false) . "' name='year' min='1900' max='2100' class='form-control  m-l-2 w-50' onchange='form.submit()'>
                </form>
                </div>
                ";

    // Create the calendar table
    $return .= "<table class='table'>";
    $return .= "<tr class='cal-header'><th>SUN</th><th>MON</th><th>TUE</th><th>WED</th><th>THU</th><th>FRI</th><th>SAT</th></tr>";

    // Create the first row of the calendar
    $return .= "<tr>";

    // Fill in empty cells before the first day of the month
    for ($i = 0; $i < $firstDay; $i++) {
        $return .= "<td></td>";
    }

    // Fill in the cells for the days of the month
    $dayCounter = 1;
    for ($i = $firstDay; $i < 7; $i++) {
        if ($dayCounter <= $numDays) {
            $return .= "<td><a";
            if ($dayCounter == $date && $month == date('n') && $year == date('Y')) {
                $return .= " class='active'";
            }
            $return .= " href='?month=$month&year=$year&day=$dayCounter'>$dayCounter</a></td>";
            $dayCounter++;
        } else {
            $return .= "<td></td>";
        }
    }

    $return .= "</tr>";

    // Fill in the rest of the rows
    for ($row = 2; $row <= 6; $row++) {
        $return .= "<tr>";
        for ($col = 0; $col < 7; $col++) {
            if ($dayCounter <= $numDays) {
                $return .= "<td><a";
                if ($dayCounter == $date && $month == date('n') && $year == date('Y')) {
                    $return .= " class='active'";
                }
                $return .= " href='?month=$month&year=$year&day=$dayCounter'>$dayCounter</></td>";
                $dayCounter++;
            } else {
                $return .= "<td></td>";
            }
        }
        $return .= "</tr>";
    }

    $return .= "</table>";

    $return .=  $Reset;

    return $return;
}

DEFINE("GENERATE_CALENDAR", OrganiseDateMonthYear());
