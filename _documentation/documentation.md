# Documentation

Specter is a video platform for multi perspective videos.
Backend and frontend are separated and interact over an API.

## Entity relationship diagram

```mermaid
%%{init: {'theme':'neutral'}}%%
erDiagram

User {
    username string
    email string
    password string
    avatar file
}
User_

Cube {
    title string
    description string
    private boolean
    thumbnail file
    duration seconds
    views number
}

Side {
    name string
    position number
    video file
}

Tag {
    name string
}

Comment {
    message string
}

History

Playlist {
    title string
    private boolean
}

User }o--o{ User_ : "subscription"
User ||--o{ Cube : "has"
User }o--o{ Cube : "likes"
User ||--|| History : "has"
History }o--o{ Cube : "has"

User ||--o{ Playlist : "has"
Playlist }o--o{ Cube : "has"

Cube ||--|{ Side : "has"
Cube }o--o{ Tag : "has"
Cube ||--o{ Comment : "has"
Comment }o--|| User : "has"
```

> IDs and timestamps are implicit.
 
> The multi perspective videos are called "cubes". Each perspective is a "side".
 
## API

A RESTful API is exposed under `/api`.
All available endpoints are documented using [Insomnia](https://insomnia.rest/).

[→ insomnia.json](insomnia.json)
