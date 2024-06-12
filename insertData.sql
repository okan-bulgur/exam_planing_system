CREATE DATABASE exam_planning_system;

USE exam_planning_system;

CREATE TABLE faculties (
    faculty_id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_name VARCHAR(50)
);

INSERT INTO faculties (faculty_name)
VALUES  ('Engineering'),
        ('Art and Sciences'),
        ('Health Sciences'),
        ('Literature'),
        ('Economics');


CREATE TABLE departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT,
    FOREIGN KEY (faculty_id) REFERENCES faculties(faculty_id),
    department_name VARCHAR(50)
);

INSERT INTO departments (faculty_id, department_name)
VALUES  (1, 'Computer Engineering'),
        (1, 'Electrical and Electronic Engineering'),
        (1, 'Industrial Engineering'),
        (2, 'Mathematics'),
        (2, 'Physics'),
        (3, 'Nutrition and Dietetics'),
        (4, 'History'),
        (5, 'International Relations');

CREATE TABLE employees (
    emp_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_username VARCHAR(50),
    emp_email VARCHAR(100),
    emp_password VARCHAR(20),
    emp_name VARCHAR(20),
    emp_surname VARCHAR(20),
    emp_role VARCHAR(50),
    emp_score INT DEFAULT 0
);

INSERT INTO employees (emp_username, emp_email, emp_password, emp_name, emp_surname, emp_role)
VALUES  ('batuhan_edguer', 'batuhan_edguer@gmail.com', '123', 'Batuhan', 'Edgüer', 'assistant'),
        ('osman_kerem_perente', 'osman_kerem_perente@gmail.com', '123', 'Osman Kerem', 'Perente', 'assistant'),
        ('gulsah_gokhan_gokcek', 'gulsah_gokhan_gokcek@gmail.com', '123', 'Gülşah', 'Gökhan Gökçen', 'assistant'),
        ('burcu_selcuk', 'burcu_selcuk@gmail.com', '123', 'Burcu', 'Selcuk', 'assistant'),
        ('ece_kartal', 'ece_kartal@gmail.com', '123', 'Ece', 'Kartal', 'assistant'),
        ('ali_bayram', 'ali_bayram@gmail.com', '123', 'Ali', 'Bayram', 'assistant'),
        ('alara_sensoy', 'alara_sensoy@gmail.com', '123', 'Alara', 'Şensoy', 'assistant'),
        ('ekin_ustundag', 'ekin_ustundag@gmail.com', '123', 'Ekin', 'Üstündağ', 'assistant'),
        ('alp_aslan', 'alp_aslan@gmail.com', '123', 'Alp', 'Aslan', 'secretary'),
        ('salih_kara', 'salih_kara@gmail.com', '123', 'Salih', 'Kara', 'secretary'),
        ('mustafa_karsli', 'mustafa_karsli@gmail.com', '123', 'Mustafa', 'Karsli', 'secretary'),
        ('selami_cetin', 'selami_cetin@gmail.com', '123', 'Selami', 'Çetin', 'secretary'),
        ('harun_deniz', 'harun_deniz@gmail.com', '123', 'Harun', 'Deniz', 'secretary'),
        ('kamil_er', 'kamil_er@gmail.com', '123', 'Kamil', 'Er', 'secretary'),
        ('ahmet_can', 'ahmet_can@gmail.com', '123', 'Ahmet', 'Can', 'secretary'),
        ('pelin_kelle', 'pelin_kelle@gmail.com', '123', 'Pelin', 'Kelle', 'secretary'),
        ('gurhan_kucuk', 'gurhan_kucuk@gmail.com', '123', 'Gürhan', 'Küçük', 'head_of_department'),
        ('mehmet_ozturk', 'mehmet_ozturk@gmail.com', '123', 'Mehmet', 'Öztürk', 'head_of_department'),
        ('furkan_bulgur', 'furkan_bulgur@gmail.com', '123', 'Furkan', 'Bulgur', 'head_of_department'),
        ('alp_cetin', 'alp_cetin@gmail.com', '123', 'Alp', 'Çetin', 'head_of_department'),
        ('ahmet_ozdemir', 'ahmet_ozdemir@gmail.com', '123', 'Ahmet', 'Özdemir', 'head_of_department'),
        ('haluk_karaduman', 'haluk_karaduman@gmail.com', '123', 'Haluk', 'Karaduman', 'head_of_department'),
        ('melih_ozkan', 'melih_ozkan@gmail.com', '123', 'Melih', 'Özkan', 'head_of_department'),
        ('mert_elli', 'mert_elli@gmail.com', '123', 'Mert', 'Elli', 'head_of_department'),
        ('ali_bas', 'ali_bas@gmail.com', '123', 'Ali', 'Bas', 'head_of_secretary'),
        ('mehmet_ali', 'mehmet_ali@gmail.com', '123', 'Mehmet', 'Ali', 'head_of_secretary'),
        ('ece_ozdemir', 'ece_ozdemir@gmail.com', '123', 'Ece', 'Özdemir', 'head_of_secretary'),
        ('ayse_kaya', 'ayse_kaya@gmail.com', '123', 'Ayşe', 'Kaya', 'head_of_secretary'),
        ('serdar_ozdemir', 'serdar_ozdemir@gmail.com', '123', 'Serdar', 'Özdemir', 'head_of_secretary'),
        ('serkan_topaloglu', 'serkan_topaloglu@gmail.com', '123', 'Serkan', 'Topaloğlu', 'dean'),
        ('serhan_doboglu', 'serhan_doboglu@gmail.com', '123', 'Serhan', 'Doboglu', 'dean'),
        ('ali_biyik', 'ali_biyik@gmail.com', '123', 'Ali', 'Biyik', 'dean'),
        ('mehmet_korkmaz', 'mehmet_korkmaz@gmail.com', '123', 'Mehmet', 'Korkmaz', 'dean'),
        ('feride_dinc', 'feride_dinc@gmail.com', '123', 'Feride', 'Dinc', 'dean');
    


CREATE TABLE emp_department (
    e_d_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT,
    department_id INT
);

INSERT INTO emp_department (emp_id, department_id)
VALUES  (1, 1),
        (2, 2),
        (3, 3),
        (4, 4),
        (5, 5),
        (6, 6),
        (7, 7),
        (8, 8),
        (9, 1),
        (10, 2),
        (11, 3),
        (12, 4),
        (13, 5),
        (14, 6),
        (15, 7),
        (16, 8),
        (17, 1),
        (18, 2),
        (19, 3),
        (20, 4),
        (21, 5),
        (22, 6),
        (23, 7),
        (24, 8);



CREATE TABLE emp_faculty (
    e_f_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT,
    faculty_id INT
);

INSERT INTO emp_faculty (emp_id, faculty_id)
VALUES  (1, 1),
        (2, 1),
        (3, 1),
        (4, 2),
        (5, 2),
        (6, 3),
        (7, 4),
        (8, 5),
        (9, 1),
        (10, 1),
        (11, 1),
        (12, 2),
        (13, 2),
        (14, 3),
        (15, 4),
        (16, 5),
        (17, 1),
        (18, 1),
        (19, 1),
        (20, 2),
        (21, 2),
        (22, 3),
        (23, 4),
        (24, 5),
        (25, 1),
        (26, 2),
        (27, 3),
        (28, 4),
        (29, 5),
        (30, 1),
        (31, 2),
        (32, 3),
        (33, 4),
        (34, 5);


CREATE TABLE emp_course (
    e_c_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT,
    course_id INT
);

CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(department_id),
    course_name VARCHAR(50),
    course_code VARCHAR(50),
    course_credits INT,
    course_term VARCHAR(50)
);

INSERT INTO courses (department_id, course_name, course_code, course_credits, course_term)
VALUES  (1, 'Computer Science', 'CS101', 3, 'Fall'),
        (1, 'Introduction to Programming', 'CS102', 3, 'Spring'),
        (2, 'Electrical Circuits', 'EC101', 3, 'Spring'),
        (3, 'Industrial Engineering', 'IE101', 3, 'Fall'),
        (4, 'Mechanical Engineering', 'ME101', 3, 'Spring'),
        (4, 'Mechanical Engineering Lab', 'ME102', 3, 'Spring'),
        (5, 'Mathematics', 'MATH101', 3, 'Fall'),
        (6, 'Physics', 'PHYS101', 3, 'Spring'),
        (7, 'Chemistry', 'CHEM101', 3, 'Fall');


CREATE TABLE Schedule (
    schedule_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    course_day INT,
    course_time TIME
);

INSERT INTO Schedule (course_id, course_day, course_time)
VALUES  (1, 1, '09:00'),
        (1, 2, '10:00'),
        (1, 5, '13:00'),
        (2, 2, '13:00'),
        (2, 3, '11:00'),
        (3, 1, '09:00'),
        (3, 2, '10:00'),
        (3, 5, '13:00'),
        (4, 2, '13:00'),
        (4, 3, '11:00'),
        (5, 1, '09:00'),
        (5, 2, '10:00'),
        (5, 5, '13:00'),
        (6, 2, '13:00'),
        (6, 3, '11:00'),
        (7, 1, '09:00'),
        (7, 2, '10:00'),
        (7, 5, '13:00'),
        (8, 2, '13:00'),
        (8, 3, '11:00'),
        (9, 1, '09:00'),
        (9, 2, '13:00'),
        (9, 3, '11:00');

CREATE TABLE exams (
    exam_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    exam_date DATE,
    exam_time TIME,
    number_of_classes INT,
    count_of_assistants INT
);

CREATE TABLE assistant_exam (
    a_e_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT,
    exam_id INT
);
