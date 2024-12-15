Create database if not exists Lab5b;

CREATE table if not exists Lab5b.users(
matric VARCHAR(10) PRIMARY KEY,
name VARCHAR(100) not null ,
password VARCHAR(255) not null,
role VARCHAR(10) not null
);