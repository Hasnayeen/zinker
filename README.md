# Under Development

The project is in early stage of development so code is unorganized and bug ridden.

## About Zinker

Zinker is a laravel code runner application. It's kind of like a poorman's Tinkerwell with lot less feature and a web app instead of a desktop app.

![demo](https://github.com/Hasnayeen/assets/blob/main/zinker_demo.gif?raw=true)

## Why

First of all [Just For Fun, Really!!!](https://justforfunnoreally.dev)

I build this for my own need. I often need to run some code in an app and don't want drop in a terminal and use tinker. While Tinkerwell is an excellent app I prefer using browser over desktop app and also I don't need all the features it provides. There is also `laravel-web-tinker` package by `spatie` but I don't want to install that in every project and also can't use it in clients project so I decided to make Zinker. Zinker is a very hacky solution so it's quite limited in its capability but it does the job for my need.

## Setup

> **Info**
> Tested this only on valet. 

Install like a regular laravel app.

- Install composer package
- Add .env file (`APP_URL` should be set properly for the app to work and use `http` protocol)
- Add database
- Run migration
- Run `php artisan zinker:install` command.
- Run `npm run build` command.

Now enjoy!

## Features

Features I intend to add in future

- [x] Run php code

- [x] Run code on any laravel application

- [x] See all the query log of your code

- [x] See model/collection data in table

- [x] See date time format and iterate on key shortcut

- [ ] Filtering and searching function for table data

- [ ] Raw SQL to Eloquent query


## Community

Join discord server for project help, announcement and more.
[Join link](https://discord.gg/4DvTQsc)

## Inspiration

This tool was inspired by [laravel-web-tinker](https://github.com/spatie/laravel-web-tinker) and [Tinkerwell](https://tinkerwell.app/)
