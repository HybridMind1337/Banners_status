Banner statistics working with GameQ
=====
The statistics were made by the team of [WEBOcean.info](https://webocean.info/)

![Author](https://img.shields.io/badge/Author-HybridMind-AA0000?style=flat-square) ![Version](https://img.shields.io/badge/Version-1.0.1-blue?style=flat-square) ![License](https://img.shields.io/badge/License-GPL%203.0%20License-greenc?style=flat-square)

### Demo:
![Demo](https://i.imgur.com/aV2SU6P.png)

### Advantage
- No problem with timeout
- Entirely with PNG
- Abbreviate the name and map of the server
- Fast load
- BBCode & Img support
- Supports many games, you can see the games [here](https://austinb.github.io/GameQ/api/namespace-GameQ.Protocols.html)

### For now, you will get the games right
- CS 1.6
- CS:GO
- CS:S
- CS: Condition Zero
- MineCraft
- SA:MP 
- MTA

### How to add more games?
If you want to add more games, just add the game icon to the `/images/games` folder, the name of the icon should be the name of the protocol written in the GameQ [API documentation](https://austinb.github.io/GameQ/api/namespace-GameQ.Protocols.html).

**Example**:
You want the banner statistics to give you statistics of the game `Team Fortress 2`, and in the API documentation the protocol is written `tf2`, the name of the icon must be `tf2.png`


### How to get the banner?
You open the statistics as a link, example:
`yoursite.com/status/index.php?ip=127.0.0.1:27015&game=cs16`

**As you will need to replace**
- **127.0.0.1:27015** with the IP address of your server
- **cs16** with the name of the game.
