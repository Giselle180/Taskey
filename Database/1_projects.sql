CREATE TABLE projects (
    id INTEGER PRIMARY KEY,
    tittle TEXT,
    description TEXT,
        ON DELETE SET NULL,
        ON UPDATE CASCADE
);