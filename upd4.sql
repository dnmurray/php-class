create table room_size (
			 abbr varchar(3) not null,
			 room_size varchar(100) not null,
			 primary key (abbr));

alter table room drop bedsize;
alter table room add roomsize varchar(3) references room_size(abbr);

insert into room_size (abbr, room_size) values ('k', 'King');
insert into room_size values ('ks', 'King w/ Sofabed');
insert into room_size values ('d', 'Double');
insert into room_size values ('2d', 'Two Doubles');
insert into room_size values ('q', 'Queen');
insert into room_size values ('2q', 'Two Queens');
