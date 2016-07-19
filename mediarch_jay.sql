# phpMyAdmin MySQL-Dump
# version 2.3.2
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Mar 29, 2003 at 08:19 PM
# Server version: 3.23.54
# PHP Version: 4.2.3
# Database : `mediarch_jay`
# --------------------------------------------------------

#
# Table structure for table `auraed`
#

CREATE TABLE auraed (
  auraid bigint(40) NOT NULL auto_increment,
  boardid bigint(40) NOT NULL default '0',
  topic mediumtext NOT NULL,
  origtopic tinyint(1) NOT NULL default '0',
  topicid bigint(40) NOT NULL default '0',
  messageid bigint(40) NOT NULL default '0',
  aurabod mediumtext NOT NULL,
  aurasec bigint(40) NOT NULL default '0',
  auradate mediumtext NOT NULL,
  postsec bigint(40) NOT NULL default '0',
  postdate mediumtext NOT NULL,
  aurauser bigint(40) NOT NULL default '0',
  auraby bigint(40) NOT NULL default '0',
  action int(2) NOT NULL default '0',
  reason int(2) NOT NULL default '0',
  PRIMARY KEY  (auraid),
  UNIQUE KEY auraid (auraid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `badlogin`
#

CREATE TABLE badlogin (
  loginid bigint(40) NOT NULL auto_increment,
  ip mediumtext NOT NULL,
  date bigint(40) NOT NULL default '0',
  username mediumtext NOT NULL,
  pass mediumtext NOT NULL,
  PRIMARY KEY  (loginid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `banned`
#

CREATE TABLE banned (
  banid bigint(40) NOT NULL auto_increment,
  username mediumtext NOT NULL,
  email mediumtext NOT NULL,
  PRIMARY KEY  (banid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `boardcat`
#

CREATE TABLE boardcat (
  id bigint(20) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  cathide bigint(1) NOT NULL default '0',
  capshow tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `boards`
#

CREATE TABLE boards (
  boardid bigint(32) NOT NULL default '0',
  boardname varchar(255) NOT NULL default '',
  boardlevel tinyint(2) NOT NULL default '0',
  type int(40) NOT NULL default '0',
  topiclevel bigint(2) NOT NULL default '0',
  messlevel bigint(2) NOT NULL default '0',
  caption varchar(255) NOT NULL default '',
  default bigint(1) NOT NULL default '0',
  PRIMARY KEY  (boardid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `contributed`
#

CREATE TABLE contributed (
  reviewid bigint(10) NOT NULL auto_increment,
  genre tinyint(1) NOT NULL default '0',
  name varchar(60) NOT NULL default '',
  synopsis varchar(150) NOT NULL default '',
  reviewer varchar(30) NOT NULL default '',
  review longtext NOT NULL,
  rating tinyint(2) NOT NULL default '0',
  date bigint(100) NOT NULL default '0',
  accepted tinyint(1) NOT NULL default '0',
  yes bigint(100) NOT NULL default '0',
  no bigint(100) NOT NULL default '0',
  PRIMARY KEY  (reviewid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `contributor`
#

CREATE TABLE contributor (
  id bigint(10) NOT NULL auto_increment,
  contribname varchar(30) NOT NULL default '',
  contribweb varchar(100) NOT NULL default '',
  contribemail varchar(50) NOT NULL default '',
  contribfull varchar(20) NOT NULL default '',
  status tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `deleted`
#

CREATE TABLE deleted (
  delid bigint(40) NOT NULL auto_increment,
  messageid bigint(40) NOT NULL default '0',
  topic bigint(40) NOT NULL default '0',
  messby mediumtext NOT NULL,
  messsec bigint(40) NOT NULL default '0',
  messbody mediumtext NOT NULL,
  mesboard bigint(40) NOT NULL default '0',
  postdate mediumtext NOT NULL,
  PRIMARY KEY  (delid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `emails`
#

CREATE TABLE emails (
  emailid bigint(40) NOT NULL auto_increment,
  email varchar(100) NOT NULL default '',
  PRIMARY KEY  (emailid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `factions`
#

CREATE TABLE factions (
  factionid bigint(40) NOT NULL auto_increment,
  name mediumtext NOT NULL,
  boardid bigint(40) NOT NULL default '0',
  PRIMARY KEY  (factionid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `favorites`
#

CREATE TABLE favorites (
  favid bigint(150) NOT NULL auto_increment,
  boardid bigint(40) NOT NULL default '0',
  userid bigint(40) NOT NULL default '0',
  PRIMARY KEY  (favid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `featured`
#

CREATE TABLE featured (
  id bigint(40) NOT NULL auto_increment,
  boardid bigint(40) NOT NULL default '0',
  PRIMARY KEY  (boardid,id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `invitations`
#

CREATE TABLE invitations (
  invid bigint(32) NOT NULL auto_increment,
  touser bigint(32) NOT NULL default '0',
  fromuser bigint(32) NOT NULL default '0',
  sendtime bigint(32) NOT NULL default '0',
  factionid bigint(32) NOT NULL default '0',
  invread tinyint(1) NOT NULL default '0',
  tempfact tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (invid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `kos`
#

CREATE TABLE kos (
  kosid bigint(40) NOT NULL auto_increment,
  alias varchar(50) NOT NULL default '',
  ip varchar(20) NOT NULL default '',
  isp varchar(50) NOT NULL default '',
  PRIMARY KEY  (kosid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `levels`
#

CREATE TABLE levels (
  level bigint(10) NOT NULL default '0',
  leveltitle mediumtext NOT NULL,
  leveldesc longtext NOT NULL,
  PRIMARY KEY  (level)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `marked`
#

CREATE TABLE marked (
  markid bigint(40) NOT NULL auto_increment,
  reason bigint(40) NOT NULL default '0',
  markwho bigint(40) NOT NULL default '0',
  message bigint(40) NOT NULL default '0',
  topic bigint(40) NOT NULL default '0',
  board bigint(40) NOT NULL default '0',
  reason2 varchar(100) NOT NULL default '',
  markby bigint(40) NOT NULL default '0',
  marksec bigint(40) NOT NULL default '0',
  markdate mediumtext NOT NULL,
  PRIMARY KEY  (markid),
  UNIQUE KEY mardid (markid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `messages`
#

CREATE TABLE messages (
  messageid bigint(10) NOT NULL auto_increment,
  topic bigint(10) NOT NULL default '0',
  messby mediumtext NOT NULL,
  messsec bigint(40) NOT NULL default '0',
  messbody longtext NOT NULL,
  mesboard bigint(10) NOT NULL default '0',
  postdate mediumtext NOT NULL,
  PRIMARY KEY  (messageid),
  UNIQUE KEY messageid (messageid),
  KEY topic (topic),
  KEY mesboard (mesboard)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `metamod`
#

CREATE TABLE metamod (
  metamodid bigint(40) NOT NULL auto_increment,
  modid bigint(40) NOT NULL default '0',
  modby bigint(40) NOT NULL default '0',
  userid bigint(40) NOT NULL default '0',
  op bigint(1) NOT NULL default '0',
  date bigint(40) NOT NULL default '0',
  PRIMARY KEY  (metamodid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `modded`
#

CREATE TABLE modded (
  modid bigint(40) NOT NULL auto_increment,
  boardid bigint(40) NOT NULL default '0',
  topic mediumtext NOT NULL,
  origtopic tinyint(1) NOT NULL default '0',
  topicid bigint(40) NOT NULL default '0',
  messageid bigint(40) NOT NULL default '0',
  modbod mediumtext NOT NULL,
  modsec bigint(40) NOT NULL default '0',
  moddate mediumtext NOT NULL,
  postsec bigint(40) NOT NULL default '0',
  postdate mediumtext NOT NULL,
  moduser bigint(40) NOT NULL default '0',
  modby bigint(40) NOT NULL default '0',
  action int(2) NOT NULL default '0',
  contest tinyint(1) NOT NULL default '0',
  contsec bigint(40) NOT NULL default '0',
  contbody mediumtext NOT NULL,
  recont tinyint(1) NOT NULL default '0',
  appealsec bigint(40) NOT NULL default '0',
  recontbody mediumtext NOT NULL,
  topmov bigint(40) NOT NULL default '0',
  reason int(2) NOT NULL default '0',
  PRIMARY KEY  (modid),
  UNIQUE KEY modid (modid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `options`
#

CREATE TABLE options (
  opid bigint(2) NOT NULL auto_increment,
  val bigint(40) NOT NULL default '0',
  PRIMARY KEY  (opid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `pollip`
#

CREATE TABLE pollip (
  voteid bigint(40) NOT NULL auto_increment,
  pollid bigint(40) NOT NULL default '0',
  ip mediumtext NOT NULL,
  PRIMARY KEY  (voteid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `pollques`
#

CREATE TABLE pollques (
  pollid bigint(40) NOT NULL auto_increment,
  date mediumtext NOT NULL,
  val mediumtext NOT NULL,
  PRIMARY KEY  (pollid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `pollsel`
#

CREATE TABLE pollsel (
  pollselid bigint(40) NOT NULL auto_increment,
  pollid bigint(40) NOT NULL default '0',
  order bigint(2) NOT NULL default '0',
  val mediumtext NOT NULL,
  votes bigint(40) NOT NULL default '0',
  PRIMARY KEY  (pollselid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `polluser`
#

CREATE TABLE polluser (
  voteid bigint(40) NOT NULL auto_increment,
  pollid bigint(40) NOT NULL default '0',
  userid bigint(40) NOT NULL default '0',
  PRIMARY KEY  (voteid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `protected`
#

CREATE TABLE protected (
  pid bigint(40) NOT NULL auto_increment,
  userid bigint(40) NOT NULL default '0',
  ip mediumtext NOT NULL,
  PRIMARY KEY  (pid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `proxy`
#

CREATE TABLE proxy (
  proxyid bigint(40) NOT NULL auto_increment,
  proxy varchar(50) NOT NULL default '',
  ip varchar(20) NOT NULL default '',
  PRIMARY KEY  (proxyid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `secmarked`
#

CREATE TABLE secmarked (
  secmarkid bigint(40) NOT NULL auto_increment,
  markid bigint(40) NOT NULL default '0',
  reason mediumtext NOT NULL,
  markwho bigint(40) NOT NULL default '0',
  message bigint(40) NOT NULL default '0',
  topic bigint(40) NOT NULL default '0',
  board bigint(40) NOT NULL default '0',
  reason2 varchar(100) NOT NULL default '0',
  markby bigint(40) NOT NULL default '0',
  marksec bigint(40) NOT NULL default '0',
  markdate mediumtext NOT NULL,
  PRIMARY KEY  (secmarkid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `secsuggested`
#

CREATE TABLE secsuggested (
  secsuggestid bigint(40) NOT NULL auto_increment,
  suggestid bigint(40) NOT NULL default '0',
  reason mediumtext NOT NULL,
  suggestwho bigint(40) NOT NULL default '0',
  message bigint(40) NOT NULL default '0',
  topic bigint(40) NOT NULL default '0',
  board bigint(40) NOT NULL default '0',
  reason2 varchar(100) NOT NULL default '',
  suggestby bigint(40) NOT NULL default '0',
  suggestsec bigint(40) NOT NULL default '0',
  suggestdate mediumtext NOT NULL,
  PRIMARY KEY  (secsuggestid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `sos`
#

CREATE TABLE sos (
  sosid bigint(40) NOT NULL auto_increment,
  ruletitle mediumtext NOT NULL,
  ruledesc mediumtext NOT NULL,
  PRIMARY KEY  (sosid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `strings`
#

CREATE TABLE strings (
  id tinyint(4) NOT NULL default '1',
  announcement text NOT NULL,
  creyear mediumtext NOT NULL,
  sitetitle varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `styles`
#

CREATE TABLE styles (
  styleid bigint(40) NOT NULL auto_increment,
  name text NOT NULL,
  link text NOT NULL,
  PRIMARY KEY  (styleid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `suggested`
#

CREATE TABLE suggested (
  suggestid bigint(40) NOT NULL auto_increment,
  reason bigint(40) NOT NULL default '0',
  suggestwho bigint(40) NOT NULL default '0',
  message bigint(40) NOT NULL default '0',
  topic bigint(40) NOT NULL default '0',
  board bigint(40) NOT NULL default '0',
  reason2 varchar(100) NOT NULL default '',
  suggestby bigint(40) NOT NULL default '0',
  suggestsec bigint(40) NOT NULL default '0',
  suggestdate mediumtext NOT NULL,
  PRIMARY KEY  (suggestid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `systemnot`
#

CREATE TABLE systemnot (
  sysnotid bigint(10) NOT NULL auto_increment,
  sysbod mediumtext NOT NULL,
  sendto bigint(20) NOT NULL default '0',
  sentat mediumtext NOT NULL,
  sentfrom bigint(20) NOT NULL default '0',
  read tinyint(1) NOT NULL default '0',
  sentsec bigint(40) NOT NULL default '0',
  PRIMARY KEY  (sysnotid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `tempfactions`
#

CREATE TABLE tempfactions (
  tfid bigint(32) NOT NULL auto_increment,
  name mediumtext NOT NULL,
  board longtext NOT NULL,
  PRIMARY KEY  (tfid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `topics`
#

CREATE TABLE topics (
  topicid bigint(10) NOT NULL auto_increment,
  topicname mediumtext NOT NULL,
  topicby mediumtext NOT NULL,
  boardnum bigint(10) NOT NULL default '0',
  active tinyint(1) NOT NULL default '0',
  timesec bigint(40) NOT NULL default '0',
  closed tinyint(1) NOT NULL default '0',
  postdate mediumtext NOT NULL,
  topicsec bigint(40) NOT NULL default '0',
  autobump tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (topicid),
  UNIQUE KEY topicid (topicid),
  KEY boardnum (boardnum)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `tos`
#

CREATE TABLE tos (
  tosid bigint(2) NOT NULL auto_increment,
  ruletitle varchar(255) NOT NULL default '',
  rulebody longtext NOT NULL,
  ruledesc mediumtext NOT NULL,
  ruleguide longtext NOT NULL,
  tosshow tinyint(1) NOT NULL default '0',
  markshow tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (tosid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `usermap`
#

CREATE TABLE usermap (
  mapid bigint(10) NOT NULL auto_increment,
  userid1 bigint(10) NOT NULL default '0',
  userid2 bigint(10) NOT NULL default '0',
  date bigint(40) NOT NULL default '0',
  PRIMARY KEY  (mapid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `users`
#

CREATE TABLE users (
  userid bigint(32) NOT NULL auto_increment,
  level bigint(32) NOT NULL default '0',
  username varchar(20) NOT NULL default '',
  userpass varchar(255) NOT NULL default '',
  contribid bigint(32) NOT NULL default '0',
  tempcontrib bigint(32) NOT NULL default '0',
  lastsid mediumtext NOT NULL,
  cookies bigint(32) NOT NULL default '0',
  aura bigint(32) NOT NULL default '0',
  regsid mediumtext NOT NULL,
  regcontrib mediumtext NOT NULL,
  email mediumtext NOT NULL,
  regdate mediumtext NOT NULL,
  lastactivity mediumtext NOT NULL,
  notify tinyint(1) NOT NULL default '0',
  regsec bigint(32) NOT NULL default '0',
  lastsec bigint(32) NOT NULL default '0',
  lastacip mediumtext NOT NULL,
  agent mediumtext NOT NULL,
  email2 varchar(50) NOT NULL default '',
  sig mediumtext NOT NULL,
  quote mediumtext NOT NULL,
  faction bigint(32) NOT NULL default '0',
  tempfaction bigint(32) NOT NULL default '0',
  rank int(3) NOT NULL default '0',
  im varchar(50) NOT NULL default '',
  imtype bigint(1) NOT NULL default '0',
  timezone decimal(3,2) NOT NULL default '0.00',
  ignore tinyint(1) NOT NULL default '0',
  regip mediumtext NOT NULL,
  closedate bigint(40) NOT NULL default '0',
  topicpage tinyint(1) NOT NULL default '1',
  topicsort tinyint(1) NOT NULL default '3',
  messagepage tinyint(1) NOT NULL default '0',
  messagesort tinyint(1) NOT NULL default '0',
  regemail mediumtext NOT NULL,
  defsec bigint(32) NOT NULL default '0',
  modcat bigint(32) NOT NULL default '0',
  featboard tinyint(1) NOT NULL default '1',
  custom tinyint(1) NOT NULL default '0',
  theme bigint(32) NOT NULL default '1',
  barshow tinyint(1) NOT NULL default '1',
  bodybgcolor varchar(20) NOT NULL default '',
  fontfamily varchar(20) NOT NULL default '',
  fontcolor varchar(20) NOT NULL default '',
  nlink varchar(20) NOT NULL default '',
  nvisited varchar(20) NOT NULL default '',
  link varchar(20) NOT NULL default '',
  visited varchar(20) NOT NULL default '',
  active varchar(20) NOT NULL default '',
  hover varchar(20) NOT NULL default '',
  cell1 varchar(20) NOT NULL default '',
  cell1f varchar(20) NOT NULL default '',
  cell2 varchar(20) NOT NULL default '',
  cell2f varchar(20) NOT NULL default '',
  cell3 varchar(20) NOT NULL default '',
  cell4 varchar(20) NOT NULL default '',
  sys varchar(20) NOT NULL default '',
  shade varchar(20) NOT NULL default '',
  darksys varchar(20) NOT NULL default '',
  bar varchar(20) NOT NULL default '',
  barf varchar(20) NOT NULL default '',
  secret bigint(32) NOT NULL default '0',
  sigspace bigint(32) NOT NULL default '0',
  sendsys bigint(32) NOT NULL default '0',
  gift1 bigint(32) NOT NULL default '0',
  gift5 bigint(32) NOT NULL default '0',
  gift10 bigint(32) NOT NULL default '0',
  gift25 bigint(32) NOT NULL default '0',
  gift50 bigint(32) NOT NULL default '0',
  gift100 bigint(32) NOT NULL default '0',
  PRIMARY KEY  (userid),
  UNIQUE KEY userid (userid),
  KEY username (username),
  KEY userpass (userpass),
  KEY userid_2 (userid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `words`
#

CREATE TABLE words (
  wordid bigint(10) NOT NULL auto_increment,
  type bigint(1) NOT NULL default '1',
  word mediumtext NOT NULL,
  exp mediumtext NOT NULL,
  PRIMARY KEY  (wordid)
) TYPE=MyISAM;

