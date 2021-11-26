****----------An internet Forum-------------****

Will include the following:
Relationships

    categories <-> posts(topic) will have many-to-many relationship
    
    topics(posts) <-> messages will have many-to-many relationship
    
    users -> posts(topics) will have one-to-many relationship
    
    users -> messages will have one-to-many relationship
Models
    Users
    Admin
    Category
    Topic
    Message
    Reply

Users
    id(pk)
    email(unique)
    username(unique)
    password
    profile-image
    points(score)
    messages
    creation date
    status
    permissions
        CRUD operations

Admin
    id(pk)
    email(unique)
    username(unique)
    password
    profile-image
    role (super-admin/moderator)
    creation date
    permissions
        Moderators - manage some designated forum section
        super-admin - manage the entire forum

Categories
    id(pk)
    title
    description
    posts(topics)
    creation date
    no_of_views
    most_viewed_post
    no_of_messages

Posts(topics)
    id(pk)
    title
    body/post content
    post_cover_image
    author(fk)
    category(fk)
    creation date
    messages
    views
    tags
    likes

Messages
    id(pk)
    body
    author(fk)
    topic/post(fk)
    creation date
    likes
    replies

Replies/comments
    id(pk)
    body
    author(fk)
    topic/post(fk)
    message(fk)
    creation date
# forum
# forum
# forum
