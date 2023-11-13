<?php

namespace App\Enums;

enum UserShio: string
{
    case RAT        = 'rat';
    case OX         = 'ox';
    case TIGER      = 'tiger';
    case RABBIT     = 'rabbit';
    case DRAGON     = 'dragon';
    case SNAKE      = 'snake';
    case HORSE      = 'horse';
    case GOAT       = 'goat';
    case MONKEY     = 'monkey';
    case ROOSTER    = 'rooster';
    case DOG        = 'dog';
    case PIG        = 'pig';

    public static function getShioByDate($date)
    {
        $dates = collect([
            ["value" => UserShio::HORSE, "start_date" => "1930-01-29", "end_date" => "1931-02-16"],
            ["value" => UserShio::GOAT, "start_date" => "1931-02-17", "end_date" => "1932-02-05"],
            ["value" => UserShio::MONKEY, "start_date" => "1932-02-06", "end_date" => "1933-01-25"],
            ["value" => UserShio::ROOSTER, "start_date" => "1933-01-26", "end_date" => "1934-02-13"],
            ["value" => UserShio::DOG, "start_date" => "1934-02-14", "end_date" => "1935-02-03"],
            ["value" => UserShio::PIG, "start_date" => "1935-02-04", "end_date" => "1936-01-23"],
            ["value" => UserShio::RAT, "start_date" => "1936-01-24", "end_date" => "1937-02-10"],
            ["value" => UserShio::OX, "start_date" => "1937-02-11", "end_date" => "1938-01-30"],
            ["value" => UserShio::TIGER, "start_date" => "1938-01-31", "end_date" => "1939-02-18"],
            ["value" => UserShio::RABBIT, "start_date" => "1939-02-19", "end_date" => "1940-02-07"],
            ["value" => UserShio::DRAGON, "start_date" => "1940-02-08", "end_date" => "1941-01-26"],
            ["value" => UserShio::SNAKE, "start_date" => "1941-01-27", "end_date" => "1942-02-14"],
            ["value" => UserShio::HORSE, "start_date" => "1942-02-15", "end_date" => "1943-02-03"],
            ["value" => UserShio::GOAT, "start_date" => "1943-02-04", "end_date" => "1944-01-24"],
            ["value" => UserShio::MONKEY, "start_date" => "1944-01-25", "end_date" => "1945-02-12"],
            ["value" => UserShio::ROOSTER, "start_date" => "1945-02-13", "end_date" => "1946-01-31"],
            ["value" => UserShio::DOG, "start_date" => "1946-02-01", "end_date" => "1947-01-21"],
            ["value" => UserShio::PIG, "start_date" => "1947-01-22", "end_date" => "1948-02-09"],
            ["value" => UserShio::RAT, "start_date" => "1948-02-10", "end_date" => "1949-01-28"],
            ["value" => UserShio::OX, "start_date" => "1949-01-29", "end_date" => "1950-02-16"],
            ["value" => UserShio::TIGER, "start_date" => "1950-02-17", "end_date" => "1951-02-05"],
            ["value" => UserShio::RABBIT, "start_date" => "1951-02-06", "end_date" => "1952-01-26"],
            ["value" => UserShio::DRAGON, "start_date" => "1952-01-27", "end_date" => "1953-02-13"],
            ["value" => UserShio::SNAKE, "start_date" => "1953-02-14", "end_date" => "1954-02-02"],
            ["value" => UserShio::HORSE, "start_date" => "1954-02-03", "end_date" => "1955-01-23"],
            ["value" => UserShio::GOAT, "start_date" => "1955-01-24", "end_date" => "1956-02-11"],
            ["value" => UserShio::MONKEY, "start_date" => "1956-02-12", "end_date" => "1957-01-30"],
            ["value" => UserShio::ROOSTER, "start_date" => "1957-01-31", "end_date" => "1958-02-17"],
            ["value" => UserShio::DOG, "start_date" => "1958-02-18", "end_date" => "1959-02-07"],
            ["value" => UserShio::PIG, "start_date" => "1959-02-08", "end_date" => "1960-01-27"],
            ["value" => UserShio::RAT, "start_date" => "1960-01-28", "end_date" => "1961-02-14"],
            ["value" => UserShio::OX, "start_date" => "1961-02-15", "end_date" => "1962-02-04"],
            ["value" => UserShio::TIGER, "start_date" => "1962-02-05", "end_date" => "1963-01-24"],
            ["value" => UserShio::RABBIT, "start_date" => "1963-01-25", "end_date" => "1964-02-12"],
            ["value" => UserShio::DRAGON, "start_date" => "1964-02-13", "end_date" => "1965-02-01"],
            ["value" => UserShio::SNAKE, "start_date" => "1965-02-02", "end_date" => "1966-01-20"],
            ["value" => UserShio::HORSE, "start_date" => "1966-01-21", "end_date" => "1967-02-08"],
            ["value" => UserShio::GOAT, "start_date" => "1967-02-09", "end_date" => "1968-01-29"],
            ["value" => UserShio::MONKEY, "start_date" => "1968-01-30", "end_date" => "1969-02-16"],
            ["value" => UserShio::ROOSTER, "start_date" => "1969-02-17", "end_date" => "1970-02-05"],
            ["value" => UserShio::DOG, "start_date" => "1970-02-06", "end_date" => "1971-01-26"],
            ["value" => UserShio::PIG, "start_date" => "1971-01-27", "end_date" => "1972-02-14"],
            ["value" => UserShio::RAT, "start_date" => "1972-02-15", "end_date" => "1973-02-02"],
            ["value" => UserShio::OX, "start_date" => "1973-02-03", "end_date" => "1974-01-22"],
            ["value" => UserShio::TIGER, "start_date" => "1974-01-23", "end_date" => "1975-02-10"],
            ["value" => UserShio::RABBIT, "start_date" => "1975-02-11", "end_date" => "1976-01-30"],
            ["value" => UserShio::DRAGON, "start_date" => "1976-01-31", "end_date" => "1977-02-17"],
            ["value" => UserShio::SNAKE, "start_date" => "1977-02-18", "end_date" => "1978-02-06"],
            ["value" => UserShio::HORSE, "start_date" => "1978-02-07", "end_date" => "1979-01-27"],
            ["value" => UserShio::GOAT, "start_date" => "1979-01-28", "end_date" => "1980-02-15"],
            ["value" => UserShio::MONKEY, "start_date" => "1980-02-16", "end_date" => "1981-02-04"],
            ["value" => UserShio::ROOSTER, "start_date" => "1981-02-05", "end_date" => "1982-01-24"],
            ["value" => UserShio::DOG, "start_date" => "1982-01-25", "end_date" => "1983-02-12"],
            ["value" => UserShio::PIG, "start_date" => "1983-02-13", "end_date" => "1984-02-01"],
            ["value" => UserShio::RAT, "start_date" => "1984-02-02", "end_date" => "1985-02-19"],
            ["value" => UserShio::OX, "start_date" => "1985-02-20", "end_date" => "1986-02-08"],
            ["value" => UserShio::TIGER, "start_date" => "1986-02-09", "end_date" => "1987-01-28"],
            ["value" => UserShio::RABBIT, "start_date" => "1987-01-29", "end_date" => "1988-02-16"],
            ["value" => UserShio::DRAGON, "start_date" => "1988-02-17", "end_date" => "1989-02-05"],
            ["value" => UserShio::SNAKE, "start_date" => "1989-02-06", "end_date" => "1990-01-26"],
            ["value" => UserShio::HORSE, "start_date" => "1990-01-27", "end_date" => "1991-02-14"],
            ["value" => UserShio::GOAT, "start_date" => "1991-02-15", "end_date" => "1992-02-03"],
            ["value" => UserShio::MONKEY, "start_date" => "1992-02-04", "end_date" => "1993-01-22"],
            ["value" => UserShio::ROOSTER, "start_date" => "1993-01-23", "end_date" => "1994-02-09"],
            ["value" => UserShio::DOG, "start_date" => "1994-02-10", "end_date" => "1995-01-30"],
            ["value" => UserShio::PIG, "start_date" => "1995-01-31", "end_date" => "1996-02-18"],
            ["value" => UserShio::RAT, "start_date" => "1996-02-19", "end_date" => "1997-02-06"],
            ["value" => UserShio::OX, "start_date" => "1997-02-07", "end_date" => "1998-01-27"],
            ["value" => UserShio::TIGER, "start_date" => "1998-01-28", "end_date" => "1999-02-15"],
            ["value" => UserShio::RABBIT, "start_date" => "1999-02-16", "end_date" => "2000-02-04"],
            ["value" => UserShio::DRAGON, "start_date" => "2000-02-05", "end_date" => "2001-01-23"],
            ["value" => UserShio::SNAKE, "start_date" => "2001-01-24", "end_date" => "2002-02-11"],
            ["value" => UserShio::HORSE, "start_date" => "2002-02-12", "end_date" => "2003-01-31"],
            ["value" => UserShio::GOAT, "start_date" => "2003-02-01", "end_date" => "2004-01-21"],
            ["value" => UserShio::MONKEY, "start_date" => "2004-01-22", "end_date" => "2005-02-08"],
            ["value" => UserShio::ROOSTER, "start_date" => "2005-02-09", "end_date" => "2006-01-28"],
            ["value" => UserShio::DOG, "start_date" => "2006-01-29", "end_date" => "2007-02-17"],
            ["value" => UserShio::PIG, "start_date" => "2007-02-18", "end_date" => "2008-02-06"],
            ["value" => UserShio::RAT, "start_date" => "2008-02-07", "end_date" => "2009-01-25"],
            ["value" => UserShio::OX, "start_date" => "2009-01-26", "end_date" => "2010-02-13"],
            ["value" => UserShio::TIGER, "start_date" => "2010-02-14", "end_date" => "2011-02-02"],
            ["value" => UserShio::RABBIT, "start_date" => "2011-02-03", "end_date" => "2012-01-22"],
            ["value" => UserShio::DRAGON, "start_date" => "2012-01-23", "end_date" => "2013-02-09"],
            ["value" => UserShio::SNAKE, "start_date" => "2013-02-10", "end_date" => "2014-01-30"],
            ["value" => UserShio::HORSE, "start_date" => "2014-01-31", "end_date" => "2015-02-18"],
            ["value" => UserShio::GOAT, "start_date" => "2015-02-19", "end_date" => "2016-02-07"],
            ["value" => UserShio::MONKEY, "start_date" => "2016-02-08", "end_date" => "2017-01-27"],
            ["value" => UserShio::ROOSTER, "start_date" => "2017-01-28", "end_date" => "2018-02-15"],
            ["value" => UserShio::DOG, "start_date" => "2018-02-16", "end_date" => "2019-02-04"],
            ["value" => UserShio::PIG, "start_date" => "2019-02-05", "end_date" => "2020-01-24"],
            ["value" => UserShio::RAT, "start_date" => "2020-01-25", "end_date" => "2021-02-11"],
            ["value" => UserShio::OX, "start_date" => "2021-02-12", "end_date" => "2022-01-31"],
            ["value" => UserShio::TIGER, "start_date" => "2022-02-01", "end_date" => "2023-01-21"],
            ["value" => UserShio::RABBIT, "start_date" => "2023-01-22", "end_date" => "2024-02-09"],
            ["value" => UserShio::DRAGON, "start_date" => "2024-02-10", "end_date" => "2025-01-28"],
            ["value" => UserShio::SNAKE, "start_date" => "2025-01-29", "end_date" => "2026-02-16"],
            ["value" => UserShio::HORSE, "start_date" => "2026-02-17", "end_date" => "2027-02-05"],
            ["value" => UserShio::GOAT, "start_date" => "2027-02-06", "end_date" => "2028-01-25"],
            ["value" => UserShio::MONKEY, "start_date" => "2028-01-26", "end_date" => "2029-02-12"],
            ["value" => UserShio::ROOSTER, "start_date" => "2029-02-13", "end_date" => "2030-02-02"],
            ["value" => UserShio::DOG, "start_date" => "2030-02-03", "end_date" => "2031-01-22"],
        ]);

        return $dates->where('start_date', '<=', $date)
                     ->where('end_date', '>=', $date)
                     ->min('value'); 
    }
}