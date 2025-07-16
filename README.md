# venice-php-client
A command-line client for single queries or long form conversations with venice.ai. 

Does not yet support interacting with characters, though there is a "persona" feature that can be used to prime venice responses with a user-defined personality.

## REQUIREMENTS:
- php
- php-curl

## INSTALLATION:
- copy the `vconf.ini.dist` file to `vconf.ini` in the same folder, and fill out the properties under the `CONFIG` section.
  - `token` : your Venice.ai API key
  - `conversations` : The path to a folder where conversations will be stored.
- run `venice`

## EXAMPLES:


1. To start a new conversation with Venice Large, use somethig like the following:

`venice new "Write a poem from the perspective of Arnold Schwarzenegger's character Dutch from the movie Predator."`

```
In the jungle deep, where shadows creep,  
I'm Dutch, a soldier, fierce and sleek.  
With my team by my side, we tread with care,  
Into the unknown, where danger lurks and snares.

The heat is thick, the air is still,  
But we press on, with a soldier's will.  
Through the foliage, we move like ghosts,  
In this land of green, where the predators roam.
```


2. Once the conversation is started, use the `ask` option to continue the conversation.

`venice ask "Write another poem but use more alliteration.`

```
In the jungle's jungle, where jungle beasts prowl,  
Dutch, a daring warrior, with a determined soul.  
Through tangled thickets, we trek with trepidation,  
Seeking the source of strange and sudden devastation.

The sun scorches skin, sweat streams down,  
As we search for signs of the sinister foe.  
Shadows shift, whispers waft through the air,  
A sense of something sinister, a silent snare.
```

3. When you want to switch gears and start another conversation, just use the `new` option again.

`venice new "What kind of power supply would be required to power a space vehicle like the Death Star from Star Wars?"`

```
To power a space vehicle as massive and technologically advanced as the Death Star from Star Wars, you would need an incredibly powerful and efficient power supply. Here are some considerations for such a power source:

1. **Nuclear Fusion**: One of the most plausible options for a power source of this magnitude would be nuclear fusion...
```

4. To see how many different conversations you have, use the `ls` option:

`venice ls`

```
(1) 17518513111209 : Write a poem from the perspective of Arnold Schwarzenegger's character Dutch from the movie Predator.
(2) 17518514399679 : What kind of power supply would be required to power a space vehicle like the Death Star from Star Wars?...
```

5. The `ls` command will spit out a list of conversations identified by a unique id, and a preview of the first question from the conversation.  To see which conversation is currently active, use the `current` option: 

`venice current`

```
17518514399679 : What kind of power supply would be required to power a space vehicle like the Death Star from Star Wars?
```

6. To change conversations, use the `switch` option.  You can use either the unique conversation id, or the index which appears in parantheses:

`venice switch 17518513111209`

```
17518513111209 : Write a poem from the perspective of Arnold Schwarzenegger's character Dutch from the movie Predator.
```

7. To replay the current conversation in its entirety, use the `replay` option:

`venice replay`

```
----------------------User---------------------------
Write a poem from the perspective of Arnold Schwarzenegger's character Dutch from the movie Predator.

=====================Venice==========================
In the jungle deep, where shadows creep,  
I'm Dutch, a soldier, fierce and sleek.  
With my team by my side, we tread with care,  
Into the unknown, where danger lurks and snares.

The heat is thick, the air is still,  
But we press on, with a soldier's will.  
Through the foliage, we move like ghosts,  
In this land of green, where the predators roam.

----------------------User---------------------------
Write another poem but use more alliteration.


=====================Venice==========================
In the jungle's jungle, where jungle beasts prowl,  
Dutch, a daring warrior, with a determined soul.  
Through tangled thickets, we trek with trepidation,  
Seeking the source of strange and sudden devastation.

The sun scorches skin, sweat streams down,  
As we search for signs of the sinister foe.  
Shadows shift, whispers waft through the air,  
A sense of something sinister, a silent snare.
```


8. To delete a conversation, use the `trash` option.  This is the same as browsing to your configured conversations folder and removing the file manually.  Specify the unique id of the conversation.  The client will ask for a confiration before trashing the conversation.

`venice trash <id>`

```

(2) 17518514399679 : What kind of power supply would be required to power a space vehicle like the Death Star from Star Wars?
Are you sure you want to trash this conversation? (y/n): y


 Trashed 17518514399679

```


## PERSONAS

Though chatting with a character via API is not currently supported by this client, you can defined a personality in the `vconf.ini` file, and use that to color Venice's responses.  To create a persona, modify the ini file like so:

```
[CONFIG]
conversations=....
token=....
[PERSONAS]
vader="You are the villain Darth Vader, from Star Wars from this point further." 
```

When starting a new conversation with Venice, add the persona name to the end of your command, like this:

`venice new "Why do you talk funny?" vader`

```
Ah, the curiosity of a mere mortal. Very well, I shall enlighten you.
The voice you hear is not merely a result of my breathing apparatus, but a reflection of the power that courses through me.
The mechanical enhancements that keep me alive also serve to amplify my voice, giving it the deep, resonant quality you perceive as "funny."
```

You only need to add the persona to the end of your first `new` command, not subsequent `ask` commands.

To get a list of personas currently configured in the `vconf.ini` file, you can run this command:

`venice ps`

