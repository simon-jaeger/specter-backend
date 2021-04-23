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
    views number
    duration seconds
    sideTop file
    sideRight file
    sideBottom file
    sideLeft file
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

Cube }o--o{ Tag : "has"
Cube ||--o{ Comment : "has"
Comment }o--|| User : "has"
```

> IDs and timestamps are implicit.
 
> The multi perspective videos are called "cubes". Each perspective is a "side".
