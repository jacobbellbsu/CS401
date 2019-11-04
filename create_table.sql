use testdb;

create table user (
	user_id int not null auto_increment primary key,
	username varchar(256) not null,
	password varchar(64) not null,
	last_read timestamp default current_timestamp
);

create table copy_followers (
	user_id int not null primary key,
	account_url varchar(512) not null
);

create table follow (
	follow_id int not null auto_increment primary key,
	user_id int not null,
	account_url varchar(512) not null
);