CREATE TABLE users (
       u_id INT NOT NULL AUTO_INCREMENT,
       username TEXT,
       hash CHAR(60),
       email VARCHAR(255),
       notifications TINYINT,
       PRIMARY KEY (u_id)
);

CREATE TABLE goals (
       g_id INT NOT NULL AUTO_INCREMENT,
       u_id INT NOT NULL,
       g_name VARCHAR(255),
       points_goal INT,
       points_current INT,
       PRIMARY KEY (g_id),
       FOREIGN KEY (u_id)
              REFERENCES users(u_id)
              ON DELETE CASCADE
);

CREATE TABLE tokens (
       t_id INT NOT NULL AUTO_INCREMENT,
       u_id INT NOT NULL UNIQUE,
       token CHAR(32),
       time_created INT,
       PRIMARY KEY (t_id),
       FOREIGN KEY (u_id)
               REFERENCES users(u_id)
               ON DELETE CASCADE
);

CREATE TABLE ratings (
       r_id INT NOT NULL AUTO_INCREMENT,
       g_id INT NOT NULL,
       u_from INT NOT NULL,
       u_to INT NOT NULL,
       rating INT NOT NULL,
       PRIMARY KEY (r_id),
       FOREIGN KEY (g_id)
               REFERENCES goals(g_id)
               ON DELETE CASCADE,
       FOREIGN KEY (u_from)
               REFERENCES users(u_id)
               ON DELETE CASCADE,
       FOREIGN KEY (u_to)
               REFERENCES users(u_id)
               ON DELETE CASCADE
);

CREATE TABLE following (
       f_id INT NOT NULL AUTO_INCREMENT,
       u_id INT NOT NULL,
       u_following INT NOT NULL,
       PRIMARY KEY (f_id),
       FOREIGN KEY (u_id)
               REFERENCES users(u_id)
               ON DELETE CASCADE,
       FOREIGN KEY (u_following)
               REFERENCES users(u_id)
               ON DELETE CASCADE
);
