create table results
(
    id    int auto_increment
        primary key,
    name  varchar(100) not null,
    class varchar(20)  not null,
    marks int          not null
);
