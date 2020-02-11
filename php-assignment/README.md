database case : snake case;
database name : php_profile;

----------------tables---------------


user_credentials:
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| id        | int(11)      | NO   | UNI | NULL    | auto_increment |
| password  | varchar(500) | NO   |     | NULL    |                |
| user_name | varchar(30)  | NO   | PRI | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+


users :
+----------------+-------------------------+------+-----+-------------------+-------+
| Field          | Type                    | Null | Key | Default           | Extra |
+----------------+-------------------------+------+-----+-------------------+-------+
| id             | int(11)                 | NO   | PRI | NULL              |       |
| first_name     | varchar(30)             | NO   |     | NULL              |       |
| last_name      | varchar(30)             | YES  |     | NULL              |       |
| age            | int(11)                 | YES  |     | NULL              |       |
| modified_on    | datetime                | NO   |     | CURRENT_TIMESTAMP |       |
| email          | varchar(30)             | YES  |     | NULL              |       |
| mobile_number  | varchar(10)             | YES  |     | NULL              |       |
| state_id       | int(11)                 | NO   | MUL | NULL              |       |
| created_on     | datetime                | NO   |     | NULL              |       |
| image_address  | varchar(100)            | YES  |     | NULL              |       |
| resume_address | varchar(100)            | YES  |     | NULL              |       |
| sex            | enum('M','F')           | YES  |     | NULL              |       |
| prefix         | enum('Mr','Mrs','Miss') | YES  |     | NULL              |       |
+----------------+-------------------------+------+-----+-------------------+-------+

skills:
+-------+-------------+------+-----+---------+----------------+
| Field | Type        | Null | Key | Default | Extra          |
+-------+-------------+------+-----+---------+----------------+
| id    | int(11)     | NO   | PRI | NULL    | auto_increment |
| skill | varchar(50) | NO   |     | NULL    |                |
+-------+-------------+------+-----+---------+----------------+

user_skills:
+----------+---------+------+-----+---------+----------------+
| Field    | Type    | Null | Key | Default | Extra          |
+----------+---------+------+-----+---------+----------------+
| id       | int(11) | NO   | PRI | NULL    | auto_increment |
| user_id  | int(11) | NO   | MUL | NULL    |                |
| skill_id | int(11) | NO   | MUL | NULL    |                |
+----------+---------+------+-----+---------+----------------+


states:
+------------+-------------+------+-----+---------+----------------+
| Field      | Type        | Null | Key | Default | Extra          |
+------------+-------------+------+-----+---------+----------------+
| state_id   | int(11)     | NO   | PRI | NULL    | auto_increment |
| state_name | varchar(30) | NO   |     | NULL    |                |
+------------+-------------+------+-----+---------+----------------+

FOREIGN KEY 
    user_credentials(id) -> users(id);
    users(state_id) -> states(state_id);
    user_skills(user_id)->users(id);
    user_skills(skill_id)->skills(id);
    
