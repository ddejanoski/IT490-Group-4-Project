CREATE TABLE IF NOT EXISTS Sessions(
    auth0_id VARCHAR(32), 
    token VARCHAR(42) NOT NULL, 
    time_generated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (auth0_id), UNIQUE (token), 
    CONSTRAINT Sessions_Accounts_auth0id_FK FOREIGN KEY (auth0_id) REFERENCES Accounts (auth0_id)
);