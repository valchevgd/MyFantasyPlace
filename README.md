# MyFantasyPlace

About

	This is the project for my final exam on “PHP MVC Frameworks - Symfony” course at SoftUni. It is a fantasy sports manager. The whole project is created using Sympfony’s components, Doctrine and Twig. Also using base Bootstrap and MySQL as database.  


Features

User’s registration
Select players
Pick players for tournaments
Upgrade players
Chat with others users
Admin panel


Rules

	Any user has 35 game coins for each sport  to pick? 5 players from this sport. For any tournament users can select 3 players from his squad with а total value up to 20 tournament coins. Players value depends on the points in World rankings. 
Snooker players win 0.1 point for every real point in the game. 5 pts for break between 50 and 59 pts, 6 pts for break between 60 and 69 points in the game and so on until break over 100. Fore any break over 100 the player wins total break value divide by 10. The sum of all of player’s points is added to user’s points for this tournament. The user with most fantasy points wins the tournament, no matter when in the real tournament his players are eliminated or not.This fantasy points will be added in user’s total fantasy tokens. This tokens can be used for upgrading his own players. 
	In darts competitions any player wins points for throwing 180’s (2.8 pts for each), over 140 (1.4 pts for each) and over 100 (0.6 for each). Alsol average by 3 darts divide by 10 and check-out percent divide by 10 . This points are added to fantasy his tokens too.
