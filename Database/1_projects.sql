CREATE TABLE projects (
    id INTEGER PRIMARY KEY,
    tittle TEXT,
    description TEXT,
        ON DELETE SET NULL,
        ON UPDATE CASCADE
);

INSERT INTO projects (title, description) VALUES
                                              ('The Fellowship of the Ring', 'Forming the fellowship and beginning the journey to Mordor'),
                                              ('The Two Towers', 'Battles, alliances and the war against Saruman'),
                                              ('The Return of the King', 'The final stand against Sauron and the return of Aragorn');