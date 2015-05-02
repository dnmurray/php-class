drop table if exists user;
create table user (
       uid int not null auto_increment,
       username varchar(25) not null,
       password varchar(255) not null,
       password_expired bool default '1',
       primary key (uid),
       unique index (username));
