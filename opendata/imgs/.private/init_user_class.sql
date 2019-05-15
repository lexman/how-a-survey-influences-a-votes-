DROP TABLE IF EXISTS user_class;
CREATE TABLE user_class (id INTEGER, pct_yes INTEGER, label STRING);

INSERT INTO user_class (id, pct_yes, label) VALUES 
    (0, 4, 'Exposed to 4% yes'), 
    (1, 15, 'Exposed to 15% yes'), 
    (2, 28, 'Exposed to 28% yes'), 
    (3, 39, 'Exposed to 39% yes'), 
    (4, 44, 'Exposed to 44% yes'), 
    (5, 49, 'Exposed to 49% yes'), 
    (6, 51, 'Exposed to 51% yes'), 
    (7, 56, 'Exposed to 56% yes'), 
    (8, 61, 'Exposed to 61% yes'), 
    (9, 72, 'Exposed to 72% yes'), 
    (10, 85, 'Exposed to 85% yes'), 
    (11, 96, 'Exposed to 96% yes'), 
    (12, NULL, 'Not exposed to a survey')
    ;
