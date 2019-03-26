INSERT INTO hotel_rooms VALUES
(100, 3), 
(101, 4), 
(404, 1);

INSERT INTO attendee (fname, lname, price) VALUES 
('chris', 'lai', 499), 
('sean', 'cahalen', 300), 
('james', 'ford', 0);

INSERT INTO student VALUES
(1, 100),
(2, 101), 
(3, NULL);

INSERT INTO attendee (fname, lname, price) VALUES 
('Paul', 'Sunders', 800), 
('Maria', 'Lee', 600), 
('Greg', 'Munn', 40);

INSERT INTO professional VALUES
(4),
(5), 
(6);

INSERT INTO sponsor_type VALUES 
('Platinum', 5, 10000),
('Gold', 4, 5000),
('Silver', 3, 3000),
('Bronze', 0, 1000);

INSERT INTO sponsor_company VALUES 
('Google', 3, 'Platinum'), 
('Microsoft', 1, 'Gold'), 
('Oracle', 2, 'Silver'), 
('Tencent', 0, 'PLatinum');

INSERT INTO attendee (fname, lname, price) VALUES 
('Bill', 'Gates', 0), 
('Larry', 'Ellison', 0), 
('Sundar', 'Pichai', 0);

INSERT INTO sponsor VALUES
(7, 'Microsoft'),
(8, 'Oracle'), 
(9, 'Google');

INSERT INTO committee_members (fname, lname) VALUES 
('chris', 'lai'), 
('sean', 'cahalen'), 
('erik', 'karlson'), 
('james', 'ford');

INSERT INTO subcommittees (name, chair) VALUES
('Program Committee', 1), 
('Registration Committee', 3);

INSERT INTO is_committee_member_of (id, name) VALUES
(1, 'Program Committee'), 
(2, 'Program Committee'),
(3, 'Registration Committee'),
(4, 'Registration Committee');

INSERT INTO is_committee_member_of (id, name) VALUES
(1, 'Program Committee'), 
(2, 'Program Committee'),
(3, 'Registration Committee'),
(4, 'Registration Committee');

INSERT INTO session VALUES
("Getting Started", 101, "2018-03-20 08:00:00", "2018-03-20 11:00:00"),
("Losing Hope", 201, "2018-03-20 12:00:00", "2018-03-20 16:00:00"),
("Finishing the Job", 101, "2018-03-20 17:00:00", "2018-03-20 19:30:00");

INSERT INTO session (name, room, start_time, end_time) VALUES
('Neural Nets', 1,'2019-06-18 10:30:00 AM','2019-06-18 11:30:00 AM'),
('AI', 2,'2019-06-19 1:30:00 PM','2019-06-19 5:30:00 PM'),
('Computer Systems', 1,'2019-06-18 12:00:00 PM','2019-06-18 3:30:00 PM'),
('Quality Assurance', 5,'2019-06-19 9:30:00 AM','2019-06-19 11:30:00 AM');

INSERT INTO is_spoken_by (speaker_id, room, start_time) VALUES
(1, 1, '2019-06-18 10:30:00 AM'), 
(1, 2,'2019-06-19 1:30:00 PM'),
(2, 1,'2019-06-18 12:00:00 PM'),
(2, 5,'2019-06-19 9:30:00 AM');

INSERT INTO advertisement VALUES
('Director of GLE', 'Google', 'Montreal', 'QC', 250000), 
('Coffee Jocky', 'Tencent', 'Georgetown', NULL, 32000), 
('Lead Specialist of Special Leaders', 'Oracle', 'Toronto', 'ON', 85000), 
('Weather Prediction Consultant', 'Oracle', 'Carcross', 'YT', 130000), 
('Minecraft Chicken Stunt Actor', 'Microsoft', 'Vancouver', 'BC', 70000);
