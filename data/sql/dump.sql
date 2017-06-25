CREATE DATABASE mkKanbanDb;

use mkKanbanDb;

CREATE TABLE kColumns (
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(80) NULL,
position INT NOT NULL,
project_id INT NOT NULL,

PRIMARY KEY id (id)
);

CREATE TABLE kTasks (
id INT NOT NULL AUTO_INCREMENT,
title VARCHAR(150) NULL,
description TEXT NOT NULL,
complexity INT NULL,
column_id  INT NOT NULL,
position INT NOT NULL DEFAULT '0',

PRIMARY KEY id (id)
);

CREATE TABLE kProjects (
id INT NOT NULL AUTO_INCREMENT,
title VARCHAR(150) NULL,

PRIMARY KEY id (id)
);

CREATE TABLE kSprints (
id INT NOT NULL AUTO_INCREMENT,
title VARCHAR(150) NULL,
project_id INT NOT NULL,
startdate DATE NULL,
enddate DATE NULL,
position INT NOT NULL,

PRIMARY KEY id (id)
);

CREATE TABLE kTasksInSprints (
id INT NOT NULL AUTO_INCREMENT,
task_id INT NOT NULL,
sprint_id INT NOT NULL,

PRIMARY KEY id (id)
);
