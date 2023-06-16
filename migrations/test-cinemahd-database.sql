create table if not exists movie
(
    id int auto_increment
        primary key,
    title varchar(255) not null,
    duration int not null
)
    engine=InnoDB;

create table if not exists people
(
    id int auto_increment
        primary key,
    firstname varchar(255) not null,
    lastname varchar(255) not null,
    date_of_birth date not null,
    nationality varchar(255) not null
)
    engine=InnoDB;

create table if not exists movie_has_people
(
    Movie_id int not null,
    People_id int not null,
    role varchar(255) not null,
    significance varchar(255) null,
    primary key (Movie_id, People_id),
    constraint fk_Movie_has_People_Movie1
        foreign key (Movie_id) references movie (id),
    constraint fk_Movie_has_People_People1
        foreign key (People_id) references people (id)
)
    engine=InnoDB;


create table if not exists type
(
    id int auto_increment
        primary key,
    name varchar(255) not null
)
    engine=InnoDB;

create table if not exists movie_has_type
(
    Movie_id int not null,
    Type_id int not null,
    primary key (Movie_id, Type_id),
    constraint fk_Movie_has_Type_Movie1
        foreign key (Movie_id) references movie (id),
    constraint fk_Movie_has_Type_Type1
        foreign key (Type_id) references type (id)
)
    engine=InnoDB;