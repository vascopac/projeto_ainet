#!/usr/bin/perl -w
use strict;

die "Invalid parameters...\n" if $#ARGV+1 != 2;

open(F1, $ARGV[0]);
open(F2, $ARGV[1]);
my $f1 = <F1>;
my $f2 = <F2>;
my $line = 1;

while(defined($f1) ne "" && defined($f2) ne "")
{
        chomp($f1);
        chomp($f2);
        if($f1 ne $f2)
        {
                print ("Linha $line: $f1 --> $f2\n");
        }
        $f1 = <F1>;
        $f2 = <F2>;
        $line++;
}


close (F1);
close (F2);
exit(0);
