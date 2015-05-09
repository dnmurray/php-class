drop table if exists room;
create table room (
       rid int not null,
       rate decimal(8,2),
       roomsize varchar(3) not null references room_size(abbr) default ('d'),
       sleeps int default '2',
			 last_upd timestamp,
       primary key (rid));

drop table if exists guest;
create table guest (
       gid int not null auto_increment,
       name varchar(100) not null,
       addr1 varchar(100) not null,
       addr2 varchar(100),
       city varchar(100),
       state char(2),
       zip varchar(10),
       phone varchar(10),
       email varchar(100),
			 password varchar(255),
			 last_upd timestamp,
       primary key (gid));

drop table if exists reservation;
create table reservation (
       rid int not null,
       gid int not null,
       arrival date not null,
       num_nights int not null,
			 last_upd timestamp,
       primary key (rid,gid),
       index ix_reservation_rid (rid),
       index ix_reservation_gid (gid));

drop table if exists user;
create table user (
       uid int not null auto_increment,
       username varchar(25) not null,
       password varchar(255) not null,
       password_expired bool default '1',
			 last_upd timestamp,
       primary key (uid),
       index (username));

drop table if exists room_size;
create table room_size (
			 abbr varchar(3) not null,
			 room_size varchar(100) not null,
			 primary key (abbr));

insert into room_size (abbr, room_size) values ('k', 'King');
insert into room_size values ('ks', 'King w/ Sofabed');
insert into room_size values ('d', 'Double');
insert into room_size values ('2d', 'Two Doubles');
insert into room_size values ('q', 'Queen');
insert into room_size values ('2q', 'Two Queens');
