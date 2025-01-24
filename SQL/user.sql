CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY, 
  email VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(10) NOT NULL,
  date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert the first user with a specific ID
INSERT INTO user (id, email, username, password, role)
VALUES (1, 'game@flix.com', 'GameFlix', '55de85e2f4a1560978c9dd479550c840', 'seller');

-- After inserting the first user, set the auto-increment value to 2
ALTER TABLE user AUTO_INCREMENT = 2;