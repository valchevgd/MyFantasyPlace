# MyFantasyPlace

### About

This is the project for my final exam on “PHP MVC Frameworks - Symfony” course at SoftUni. It is a fantasy sports manager. The whole project is created using Sympfony, Doctrine and Twig. Also using base Bootstrap and MySQL as database.  


### Features

- Sports: darts and snooker
- User’s profile
- Select players 
- Upgrade players 
- Season and tournament statistic
- Users standing
- Admin panel


### Rules

Any user has 35 game coins for each sport  to pick? 5 players from this sport. For any tournament users can select 3 players from his squad with а total value up to 20 tournament coins. Players value depends on the points in World rankings. 
Snooker players win 0.1 point for every real point in the game. 5 pts for break between 50 and 59 pts, 6 pts for break between 60 and 69 points in the game and so on until break over 100. Fore any break over 100 the player wins total break value divide by 10. The sum of all of player’s points is added to user’s points for this tournament. The user with most fantasy points wins the tournament, no matter when in the real tournament his players are eliminated or not.This fantasy points will be added in user’s total fantasy tokens. This tokens can be used for upgrading his own players. 
In darts competitions any player wins points for throwing 180’s (2.8 pts for each), over 140 (1.4 pts for each) and over 100 (0.6 for each). Alsol average by 3 darts divide by 10 and check-out percent divide by 10 . This points are added to fantasy his tokens too.


### How to run it

First of all its Symfony project, so you can do every requirements to run an Symfony's project (install/update composer, create database, update schema and so on...).
In 'roles' table you should add 'ROLE_USER' and 'ROLE_ADMIN'. After that you can register users. To use one of them like admin, just give him a role 'ROLE_ADMIN'(in table 'users_roles'). Now you can start adding players and tournaments. Also you can use my sql file (MFP.sql) and insert both sports top 32 ranking players (ranking from beginning of 2019). There is tournaments too. All darts tournaments form 2019 season and remaining snookers tournaments until the end of 2018-2019 season.

### How it works

When admin (or inserts) done with their jobs, users can select players to join in there team. With any purchase user`s budget will decreased. Any user can remove everyone of his players. But can do only one remove between tournaments(that move can be make even when tournament is running) but user will lose any progres on upgrading this player.Also user can upgrade his players and that will have effect only on his own player. But for that user's need Fantasy Tokens. How to earn it ? On tournaments. 
Admins can start next tournament and select players who will participate in it (this player's status will change to 'running'). Now admin can update player's results. After some player is ruling out his result can't be updated any more. After tournament is over (any player are ruled out) its time to update players value(to new season ranking). Then admin can finished this tournament (any players statistic will be set at 0 (zero) and users will have right of players remove).
With removeing players on admin side it ends the season. Admin should drop any player who drop of top 32 of sport's ranking. On users who will lost players will be added player's value in their budget.  Then any stats and points of this sport are reset to 0 (zero)(Fantasy tokens will be retained). Its time to add newcomers in top 32, аdding new tournaments of the season and everything will start once again.

### HAVE A FUN ! AND WISH ME LUCK ON MY EXAM :)