
-- Create the database
CREATE DATABASE IF NOT EXISTS instagram_clone;

-- Select the database to use
USE instagram_clone;

-- Create the `users` table to store user information
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Auto-incrementing user ID
    username VARCHAR(255) NOT NULL UNIQUE, -- Username must be unique
    password VARCHAR(255) NOT NULL,     -- User password (hashed)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Account creation timestamp
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Account update timestamp
);

-- Insert sample data with hashed passwords (no email field)
INSERT INTO users (username, password) VALUES 
('john_doe', '$2y$10$zcsqFdqaMa9IDyUTpuPygutBog9kiNz9ecNgMyew.yVtUE7CGPhrC'),  -- Original password: password123
('jane_doe', '$2y$10$qsRZ2OuTQSqqfBZfbIAjlew9oJ/jnZDL6AN7tzLpv4cvJHtKzyb4G'), -- Original password: password123
('alice_smith', '$2y$10$Nvo5FS7jivRlhCc7Wp4K/.AySMWPkwGLBpZv/dQgWSA0dhuidKt7'), -- Original password: alice123
('bob_jones', '$2y$10$CMkh35x4pFsx3vCYyd0TSuMwfjHhCdUU3ZIzaT1GMXmG4JAwAruMq'),   -- Original password: bob123
('charlie_brown', '$2y$10$AD1I.m0y1Q4Tr.Rztz1pTOWMj.s81CTapfovf7kXc9HWG88iaMAUu'), -- Original password: charlie123
('diana_white', '$2y$10$pqL12mU/eDqf0CahydeaT.Y1huJ6YMpF8UNEVNDvRt/a8Amar68Ke'); -- Original password: diana123

-- Create the `photos` table to store photos uploaded by users
CREATE TABLE IF NOT EXISTS photos (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Auto-incrementing photo ID
    user_id INT NOT NULL,               -- Foreign key to the `users` table
    file_path VARCHAR(255) NOT NULL,     -- Path to the photo file (e.g., file path in the server)
    caption TEXT,                       -- Caption for the photo
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Photo upload timestamp
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Foreign key constraint with cascading delete
);

-- Insert some photos for the sample users
INSERT INTO photos (user_id, file_path, caption, created_at) VALUES 
(1, 'bd1938b369d87e05d3c6be73d0cbe38b', 'My first photo', '2025-01-01 12:00:00'),
(1, 'd12d2203225a8e4653fb4461f50785ee', 'Another cool shot', '2025-01-02 14:30:00'),
(1, 'b894b4b44177306322c801ca8f5517ef', 'Exploring the beach', '2025-01-03 16:45:00'),
(2, 'c703a7ec0a99b94fdea89ef9e9fdd36e', 'Exploring the city', '2025-01-04 09:15:00'),
(2, 'a036b29a73d91926f334dd3c7a923c0c', 'Lovely sunset', '2025-01-05 18:30:00'),
(2, '455a6cff1fac4308f95c02dfa339e295', 'Coffee time!', '2025-01-06 08:00:00'),
(3, '8d140c7830612d1b7b819fcf16f82416', 'Alice in the park', '2025-01-07 11:20:00'),
(3, '8acd3142b58bf54b32cc4d7102c9eefc', 'A beautiful hike', '2025-01-08 17:00:00'),
(4, '5b0ab10dfa89aecdcae340c455ac171e', 'Bob’s vacation', '2025-01-09 13:10:00'),
(4, '4342e3c5e913db144bb3380fcaee5f7e', 'Bob and his friends', '2025-01-10 20:00:00'),
(5, 'b77e6b99600c0e46b53a00eb5f1e5f54', 'Charlie at the beach', '2025-01-11 07:30:00'),
(5, '1ec7505f6b0ad2b9ea568b0579cd3b0c', 'Chilling at the pool', '2025-01-12 19:45:00'),
(6, '69c07fee7b98c4ca87ffe3c6b0bd707d', 'Diana on a bike ride', '2025-01-13 10:30:00'),
(6, '455a6cff1fac4308f95c02dfa339e295', 'Diana’s morning run', '2025-01-14 06:15:00');


-- Create the `followers` table to manage user relationships (who follows whom)
CREATE TABLE IF NOT EXISTS followers (
    follower_id INT NOT NULL,           -- User ID of the follower
    following_id INT NOT NULL,          -- User ID of the followed user
    PRIMARY KEY (follower_id, following_id), -- Composite primary key (follower and following)
    FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE, -- Cascade delete when user is deleted
    FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE -- Cascade delete when user is deleted
);

-- Insert follower relationships between users
INSERT INTO followers (follower_id, following_id) VALUES 
(1, 2),  -- John follows Jane
(1, 3),  -- John follows Alice
(1, 4),  -- John follows Bob
(2, 1),  -- Jane follows John
(2, 5),  -- Jane follows Charlie
(3, 2),  -- Alice follows Jane
(3, 4),  -- Alice follows Bob
(3, 6),  -- Alice follows Diana
(4, 1),  -- Bob follows John
(4, 5),  -- Bob follows Charlie
(5, 1),  -- Charlie follows John
(5, 2),  -- Charlie follows Jane
(5, 3),  -- Charlie follows Alice
(5, 6),  -- Charlie follows Diana
(6, 1),  -- Diana follows John
(6, 3),  -- Diana follows Alice
(6, 4),  -- Diana follows Bob
(6, 5);  -- Diana follows Charlie

