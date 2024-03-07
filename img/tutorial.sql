CREATE TABLE registered(
    Id int PRIMARY KEY AUTO_INCREMENT,
    Username varchar(200) NOT NULL,
    Name varchar(200) NOT NULL,
    Email varchar(200) NOT NULL,
    Age int NOT NULL,
    Password varchar(200) NOT NULL,
    flag boolean DEFAULT FALSE
);
CREATE TABLE travelform (
    user_Id int PRIMARY KEY,
    dest varchar(200) NOT NULL,
    time time NOT NULL,
    FOREIGN KEY (user_Id) REFERENCES registered(Id)
);
