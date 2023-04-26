CREATE USER 'php-course-app'@'%' IDENTIFIED BY 'gX5t2UUbBn';

CREATE DATABASE php_course;
GRANT ALL ON php_course.* TO 'php-course-app'@'%';
