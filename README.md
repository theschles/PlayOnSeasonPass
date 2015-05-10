# PlayOnSeasonPass

As there's no officially announced release date for Season Pass auto-recording of shows in PlayOn.TV / PlayLater.TV -- see one such feature request here: https://support.playon.tv/entries/20676453-auto-recording -- I've decided to start writing a PHP script to do just that.

User Stories (initial list): 
- As a PlayLater user/owner, I want a script/program to store a list of shows I like -- so that I can identify which shows I want the script/program to order PlayLater to record when new episodes become available on PlayLater
- As a PlayLater user/owner, I want that script/program to send record commands to PlayLater when a new episode is published by PlayLater -- so that those new episodes are recorded
- As a PlayLater user/owner, I want that script/program to check for new episodes daily -- so that I don't miss anything new
- As a PlayLater user/owner, I want to specify to the script/program the minimum length episode to record -- so that I can record both clips and full episodes if I'd like, or I can just record full episodes
- As a PlayLater user/owner, I want the script/program to send me an email whenever a record command is issued (if I choose to receive such emails) -- so that I can know that the script/program is doing its job
- As a PlayLater user/owner, I want the script/program to send me an email whenever it scans the list of episodes for my list of shows I like (if I choose to receive such emails) -- so that I can know that the script/program is doing its job
