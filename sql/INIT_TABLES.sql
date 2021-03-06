# Populate the Positions table

INSERT INTO
hourly.positions (
hourly.positions.id,
hourly.positions.position,
hourly.positions.admin
) VALUES (
DEFAULT,
"Admin",
1
);

# Populate the Companies table

INSERT INTO 
hourly.companies (
hourly.companies.id,
hourly.companies.name,
hourly.companies.ceo,
hourly.companies.liability,
hourly.companies.state,
hourly.companies.businessaddress,
hourly.companies.parentcompany,
hourly.companies.registrarfirstname,
hourly.companies.registrarlastname,
hourly.companies.registrarcompanyposition,
hourly.companies.registraremail,
hourly.companies.creationdate
) VALUES (
DEFAULT, 
"Hourly", 
"Administrator", 
"Full", 
"Queensland", 
"13 Matrix St", 
"", 
"Admin", 
"Istrator", 
"Admin",
"Admin@Hourly.com", 
DEFAULT
);

# Populate the Accounts table

INSERT INTO 
hourly.accounts (
hourly.accounts.username,
hourly.accounts.email,
hourly.accounts.password,
hourly.accounts.company,
hourly.accounts.positionid
) VALUES (
'Admin',
'Admin@Hourly.com',
'7B7BC2512EE1FEDCD76BDC68926D4F7B',
'Hourly',
'1'
);

# Populate the News table

INSERT INTO 
hourly.news (
hourly.news.id,
hourly.news.author,
hourly.news.date,
hourly.news.title,
hourly.news.content
) VALUES (
DEFAULT,
"Admin",
CURRENT_TIMESTAMP,
"Welcome",
"If you can see this post then the News table has been populated with initilisation data and is working as intended."
);

# Populate the Days table

INSERT INTO
hourly.days (
hourly.days.id,
hourly.days.dayname
) VALUES (
DEFAULT,
"Monday"
);

INSERT INTO
hourly.days (
hourly.days.id,
hourly.days.dayname
) VALUES (
DEFAULT,
"Tuesday"
);

INSERT INTO
hourly.days (
hourly.days.id,
hourly.days.dayname
) VALUES (
DEFAULT,
"Wednesday"
);

INSERT INTO
hourly.days (
hourly.days.id,
hourly.days.dayname
) VALUES (
DEFAULT,
"Thursday"
);

INSERT INTO
hourly.days (
hourly.days.id,
hourly.days.dayname
) VALUES (
DEFAULT,
"Friday"
);

INSERT INTO
hourly.days (
hourly.days.id,
hourly.days.dayname
) VALUES (
DEFAULT,
"Saturday"
);

INSERT INTO
hourly.days (
hourly.days.id,
hourly.days.dayname
) VALUES (
DEFAULT,
"Sunday"
);