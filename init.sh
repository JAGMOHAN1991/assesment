#!/bin/bash
echo "export PDCDIR=$(pwd)" >> ~/.bash_profile
echo 'alias dev="sh $PDCDIR/dev-container/bash/assesment.sh"' >> ~/.bash_profile

# This will to zsh if exist
ZSH=~/.zshrc
if [ -f "$ZSH" ]; then
    echo "export PDCDIR=$(pwd)" >> ~/.zshrc
    echo 'alias dev="sh $PDCDIR/dev-container/bash/assesment.sh"' >> ~/.zshrc
fi


