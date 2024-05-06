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
        (1, 'Mechanical Engineering'),
        (2, 'Mathematics'),
        (2, 'Physics'),
        (2, 'Chemistry'),
        (3, 'Nutrition and Dietetics'),
        (3, 'Nursing'),
        (3, 'Physiotherapy'),
        (4, 'Turkish Language and Literature'),
        (4, 'English Language and Literature'),
        (4, 'History'),
        (5, 'Economics'),
        (5, 'Business Administration'),
        (5, 'International Relations');

CREATE TABLE employees (
    emp_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_username VARCHAR(50),
    emp_email VARCHAR(100),
    emp_password VARCHAR(20),
    emp_name VARCHAR(20),
    emp_surname VARCHAR(20),
    emp_role VARCHAR(50)
);

INSERT INTO employees (emp_username, emp_email, emp_password, emp_name, emp_surname, emp_role)
VALUES  ('okan_bulgur', 'okan_bulgur@gmail.com', '123', 'Okan', 'Bulgur', 'assistant'),
        ('furkan_bulgur', 'furkan_bulgur@gmail.com', '123', 'Furkan', 'Bulgur', 'assistant'),
        ('burcu_selcuk', 'burcuselcuk@gmail.com', '123', 'Burcu', 'Selcuk', 'secretary'),
        ('gurhan_kucuk', 'gurhan_kucuk@gmail.com', '123', 'Gürhan', 'Küçük', 'head_of_department'),
        ('ali_bas', 'ali_bas@gmail.com', '123', 'Ali', 'Bas', 'head_of_secretary'),
        ('serkan_topaloglu', 'serkan_topaloglu@gmail.com', '123', 'Serkan', 'Topaloğlu', 'dean');
    


CREATE TABLE emp_department (
    e_d_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT,
    department_id INT
);

INSERT INTO emp_department (emp_id, department_id)
VALUES  (1, 1),
        (2, 1),
        (3, 2),
        (4, 1),
        (5, 1),
        (6, 2);


CREATE TABLE emp_course (
    e_c_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT,
    course_id INT
);

INSERT INTO emp_course (emp_id, course_id)
VALUES  (1, 1),
        (1, 2),
        (1, 3),
        (2, 2),
        (2, 4);


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


CREATE TABLE exams (
    exam_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    exam_date DATE,
    exam_time TIME,
    number_of_classes INT,
    count_of_assistants INT
);

INSERT INTO exams (course_id, exam_date, exam_time, number_of_classes, count_of_assistants)
VALUES  (1, '2024-05-06', '09:00:00', 2, 2),
        (2, '2024-05-09', '11:00:00', 2, 2),
        (3, '2024-05-05', '09:00:00', 1, 1),
        (4, '2024-05-10', '11:00:00', 2, 2),
        (5, '2024-05-12', '09:00:00', 2, 2),
        (6, '2024-05-13', '11:00:00', 2, 2),
        (7, '2024-05-14', '11:00:00', 3, 3),
        (8, '2024-05-15', '18:00:00', 4, 4),
        (9, '2024-05-16', '09:00:00', 1, 1);


CREATE TABLE assistant_exam (
    a_e_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT,
    exam_id INT
);

INSERT INTO assistant_exam (emp_id, exam_id)
VALUES  (1, 1),
        (1, 2),
        (1, 3),
        (1, 4),
        (2, 1),
        (2, 2),
        (2, 3),
        (2, 5),
        (2, 6);