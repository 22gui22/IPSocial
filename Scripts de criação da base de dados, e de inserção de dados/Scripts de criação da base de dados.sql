CREATE DATABASE ips;
CREATE TABLE Users (
	Users_Id int(5) PRIMARY KEY AUTO_INCREMENT,
	Users_FirstName varchar(50) COLLATE utf8_general_ci not null,
	Users_LastName varchar(50) COLLATE utf8_general_ci not null,
	Users_BirthDate date not null,
	Users_Number int(15) not null,
	Users_Country varchar(35) COLLATE utf8_general_ci not null,
	Users_District varchar(35) COLLATE utf8_general_ci not null,
	Users_City varchar(35) COLLATE utf8_general_ci not null,
	Users_Gender varchar(3) COLLATE utf8_general_ci not null,
	Users_Phone int(10) not null,
	Users_ProfileColor varchar(35) COLLATE utf8_general_ci not null,
	Users_ProfileColor2 varchar(35) COLLATE utf8_general_ci not null,
	Users_Email varchar(50) COLLATE utf8_general_ci not null,
	Users_Password varchar(35) COLLATE utf8_general_ci not null,
	Users_Photo varchar(200) COLLATE utf8_general_ci not null,
	Users_Year int(10) not null,
	Users_Course_Id int(5) not null,
	FOREIGN KEY (Users_Course_Id) REFERENCES Couse_Id(course));
					 				 
CREATE TABLE Follows (
    Follows_Id int(5) PRIMARY KEY AUTO_INCREMENT,
    Follower_Id int(5) not null,
    Following_Id int(5) not null,
    FOREIGN KEY (Follower_Id) REFERENCES Users_id(users),
    FOREIGN KEY (Following_Id) REFERENCES Users_id(users));

CREATE TABLE School (
    School_Id int(5) PRIMARY KEY AUTO_INCREMENT,
    School_Name varchar(50) COLLATE utf8_general_ci not null);
	
CREATE TABLE Course (
    Course_Id int(5) PRIMARY KEY AUTO_INCREMENT,
    Course_Name varchar(100) COLLATE utf8_general_ci not null,
	Course_Year int(10) not null,
	Course_School_Id int(5) not null,
	FOREIGN KEY (Course_School_Id) REFERENCES School_Id(school));
	
CREATE TABLE Post (
    Post_Id int(5) PRIMARY KEY AUTO_INCREMENT,
    Post_Image varchar(200) COLLATE utf8_general_ci not null,
	Post_Description varchar(250) COLLATE utf8_general_ci,
	Post_Users_Id int(5) not null, 
	FOREIGN KEY (Post_Users_Id) REFERENCES Users_Id(users));
    
CREATE TABLE Comments (
	Comments_Id int(5) PRIMARY KEY AUTO_INCREMENT,
	Comments_Date date not null,
	Comments_Comment varchar (250) COLLATE utf8_general_ci not null,
	Comments_Post_Id int(5) not null,
	Comments_Users_Id int(5) not null,
	FOREIGN KEY (Comments_Post_Id) REFERENCES Post_Id(post),
	FOREIGN KEY (Comments_Users_Id) REFERENCES Users_Id(users));
	
CREATE TABLE Likes (
	Likes_Id int(5) PRIMARY KEY AUTO_INCREMENT,
	Likes_Users_Id int(5) not null,
	Likes_Post_Id int(5) not null,
	FOREIGN KEY (Likes_Users_Id) REFERENCES Users_Id(users),
	FOREIGN KEY (Likes_Post_Id) REFERENCES Post_Id(post));
	
CREATE TABLE Groups (
	Groups_Id int(5) PRIMARY KEY AUTO_INCREMENT,
	Groups_Name varchar(100) COLLATE utf8_general_ci not null,
	Groups_Photo varchar(200) COLLATE utf8_general_ci not null,
	Groups_Description varchar(250) COLLATE utf8_general_ci not null,
	Groups_Users_Id int(5) not null,
	FOREIGN KEY (Groups_Users_Id) REFERENCES Users_Id(users));
	
CREATE TABLE GroupMembers (
	GroupMembers_Id int(5) PRIMARY KEY AUTO_INCREMENT,
    GroupMembers_Follower_Id int(5) not null,
    GroupMembers_Groups_Id int(5) not null,
    FOREIGN KEY (GroupMembers_Follower_Id) REFERENCES Users_Id(users),
    FOREIGN KEY (GroupMembers_Groups_Id) REFERENCES Groups_Id(groups)); 
	
CREATE TABLE Privacy (
	Privacy_Id int(5) PRIMARY KEY AUTO_INCREMENT,
	Privacy_Gender int(5) not null,
	Privacy_BirthDate int(5) not null,
	Privacy_Post int(5) not null,
	Privacy_Location int(5) not null,
	Privacy_Users_Id int(5) not null,
	FOREIGN KEY (Privacy_Users_Id) REFERENCES Users_Id(users));

CREATE TABLE Notifications (
    Notifications_Id int(5) PRIMARY KEY AUTO_INCREMENT,
    Notifications_Content varchar(100) COLLATE utf8_general_ci not null,
    Notifications_Date datetime not null,
    Notifications_Sender_Id int(5) not null,
    Notifications_Receiver_Id int(5) not null,
	Notifications_Photo varchar(200) COLLATE utf8_general_ci,
    FOREIGN KEY (Notifications_Sender_Id) REFERENCES Users_Id(users),
    FOREIGN KEY (Notifications_Receiver_Id) REFERENCES Users_Id(users));
	
CREATE TABLE Chat (
	Chat_Id int(5) PRIMARY KEY AUTO_INCREMENT,
	Chat_Message varchar(200) COLLATE utf8_general_ci not null,
	Chat_Date datetime not null,
	Chat_Sender_Id int (5) not null,
	Chat_Receiver_Id int(5) not null,
	FOREIGN KEY (Chat_Sender_Id) REFERENCES Users_Id(users),
	FOREIGN KEY (Chat_Receiver_Id) REFERENCES Users_Id(users));

CREATE TABLE Local (
    Local_Id int(5) PRIMARY KEY AUTO_INCREMENT,
    Local_Group_Id int(10),
    Local_Users_Id int(10), 
    Local_Post_Id int(5) not null,
    FOREIGN KEY (Local_Group_Id) REFERENCES Group_Id(groups),
    FOREIGN KEY (Local_Users_Id) REFERENCES Users_Id(users),
    FOREIGN KEY (Local_Post_Id) REFERENCES Post_Id(post));