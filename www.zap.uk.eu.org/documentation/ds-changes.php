<?php
  // $Id: ds-changes.php,v 1.1 2002/01/23 20:27:04 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/ds-changes');
  include "../.php/zap-changes.inc";
  zap_header ("Zap - Darren Salt's changes", 'up:changes', 'prev:tmt-changes', 'next:sja-changes');
  zap_body_start ();
?>

<h1>Changes by Darren Salt:</h1>

 <ol>
  <li>
   Block editing implemented on a per-mode basis. It affects
   <code>CHAR</code>, <code>DELETE</code>, <code>DELETENEXT</code>,
   <code>DELTOSTART</code>, <code>DELTOEND</code>, <code>TAB</code> and
   related commands (more specifically, the mode entry points
   <em>e_char</em>, <em>e_delete</em> and <em>e_tab</em>). <em>Text</em> mode
   provides support in these places; many modes will inherit this behaviour.
   <em>Wordwrap=off</em> and <em>linewrap=off</em> are disabled when editing within
   the selection with this option enabled.

  <li>
   Dynamic sub-style loading implemented.

  <li>
   Alt double click causes some action to be taken on the text at the cursor.
   Normally, this is a word; it may, however, be something looked up by a
   function.  The action is a Zap command which takes a string parameter; the
   function used is of the same name as the command, but takes as its
   parameter the file offset (this is optional, but preferred), and returns a
   string.
   <br>
   An extra configuration file, ZapUser:Config.ClickSend
   (&lt;Zap$ClickSend&gt;), is provided for this. See this file for more
   details.
   <br>
   (Mode type &quot;BASIC&quot; renamed as &quot;Tokenised&quot;.)

  <li>
   Command arguments:
   <ul>
    <li>Dynamic (evaluated on the fly):
     <table border=0>
      <tr>
       <td><kbd>$(...)</kbd>
       <td>string parameter (numbers automatically converted)
      <tr>
       <td><kbd>#(...)</kbd>
       <td>byte or word parameter
      <tr>
       <td><kbd>@(...)</kbd>
       <td>as <kbd>$(...)</kbd>; <em>deprecated</em>
     </table>
    <li>Static (evaluated once only, at parse time):
     <table border=0>
      <tr>
       <td><kbd>$<em>fn</em></kbd>
       <td>string parameter (numbers automatically converted)
      <tr>
       <td><kbd>#<em>fn</em></kbd>
       <td>byte or word parameter
      <tr>
       <td><kbd>$=(...)</kbd>
       <td>string expression (numbers automatically converted)
      <tr>
       <td><kbd>#=(...)</kbd>
       <td>numeric expression (numbers automatically converted)
      <tr>
       <td><kbd>@<em>fn</em></kbd>
       <td>as <kbd>$<em>fn</em></kbd>; <em>deprecated</em>
     </table>

    <li>
     These changes are intended to allow bracketed expressions to be supplied
     to commands and functions which require byte or word parameters.

    <li>
     Function arguments (syntax shown above). The argument is always
     evaluated when the function is evaluated.

    <li>
     Note to <em>Zap</em> developers and extension authors:
     <br>
     <em>Zap_ProcessCommand</em> and <em>Zap_ProcessKeyCommand</em>
     have changed slightly; this will only affect usage where the command
     data has been generated from a string supplied by the user or read from
     a config file.

   </ul>

  <li>
   Dynamic expression arguments may be used for commands in menus, keys and
   types definitions.

  <li>
   String expression evaluation available via
   <em>Zap_EvaluateExpression</em>.

  <li>
   Numeric arguments may be enclosed in either parentheses or quotation
   marks.

  <li>
   Clicking on the portrait and landscape options in the 'fancy print' dbox
   causes an update of the page dimensions. Also, the 'add title' option icon
   is initialised correctly.

  <li>
   Colour optionally added to fancy print :-)
   <br>
   The 'use colour' option is initialised according to the printer driver
   settings.

  <li>
   Keyboard handling markedly improved via the keycode and modifier buffering
   performed by the <em>KeyboardExtend</em> module (provided as a Zap
   extension). (<em>Zap</em> will revert to the old behaviour if this module
   is not present.) Note that this requires that commands (except for those
   which cannot be sensibly bound to a key) may not check <em>Shift</em> or
   <em>Ctrl</em> unless they're waiting for them to be pressed or released.

  <li>
   New commands <code>SET</code>, <code>UNSET</code> for <em>Zap</em>
   variables.

   <ul>
    <li>
     Variable names may contain letters, digits, '`', '_' and '$'; they must
     not start with a digit or '$'.

    <li>
     Variables may be included in expressions as follows:
     <table border=0>
      <tr>
       <td><kbd>@$<em>var</em></kbd>
       <td>string variable
      <tr>
       <td><kbd>@#<em>var</em></kbd>
       <td>integer variable
      <tr>
       <td><kbd>@$<em>var</em></kbd>
       <td>string variable to be evaluated as a <em>Zap</em> expression
     </table>
    </ul>

  <li>
   New <em>Zap</em> call, <em>Zap_ClaimMessage</em>. Necessary for
   protocols where a SWI may be replied to with a WIMP message; Acorn's
   <em>URI dispatch protocol</em> is one such. (<em>ZapDS</em> uses this
   call.)

  <li>
   Command strings may now include comments, eg.<br>
   <code>WIBBLE &quot;foo&quot; ; do something:WIBBLE &quot;bar&quot; ; do
   something else</code><br>
   Comments may not include ':'.

  <li>
   Byte and Word modes: clicking on a character in the character dump now
   positions the cursor over the appropriate byte or word.

  <li>
   Default click behaviour in Byte, Word and ASCII modes changed to allow
   double, triple and quadruple clicks to select words, lines and the whole
   buffer.

  <li>
   New structure commands:

   <ul compact>
    <li><code>IF...THEN...[ELSE]...ENDIF</code>
    <li><code>REPEAT...UNTIL</code>
    <li><code>WHILE...ENDWHILE</code>
    <li><code>CASE...WHEN...DEFAULT...ENDCASE</code>
    <li><code>CWHEN</code> C-like alternative to <code>WHEN</code>
    <li><code>BREAK</code>, <code>CONTINUE</code>
   </ul>

   <br>
   Infinite loops may be escaped from by pressing Alt-Escape.

  <li>
   <em>Zap_Ensure</em> and <em>Zap_Extend</em> may have R0=0. If so, they set
   R0=R1 and jump to <em>Zap_Claim</em>.

  <li>
   <code>LOCAL</code> variables implemented. Scope is the current command
   block (string).

  <li>
   Minibuffer filename completion improved. It will now work in situations such
   as<br>
   <code>FINDFILE &quot;ADFS::HardDisc4.$.Apps.!Zap.C&quot;</code><br>
   (command flags permitting).
   <br>
   Note that it will <strong>not</strong> work where the partial filename is
   enclosed in parentheses, since these may be part of the filename.

  <li>
   Minibuffer scrolling improved, wrt caret position.

  <li>
   The minibuffer may be drawn using either the system font or the desktop font.
   <em>Options.Minifuffer.System font</em> controls this.

  <li>
   Dragging a file or directory to the minibuffer results in its name being
   inserted.

  <li>
   Minibuffer early closure bug fixed. (This bug affected any warning
   displayed before the previous one had timed out.)

  <li>
   Support for 'big' discs added to the 'DZap' dialogue.
   <br>
   'Big' disks (&gt;=512MB) use a sector address instead of a disk address.
   (The sector address is the disk address divided by the sector size.) The
   disk size will be given as a 16-digit number, and the file title will
   contain the disk address (again, 16 digits). Small disks (&lt;512MB) are
   unaffected by these changes.

  <li>
   Added <code>NEXTCYLINDER</code> and <code>LASTCYLINDER</code> commands.
   The front end is currently not affected by this.</LI>

  <li>
   New dbox &quot;Movebox&quot; for use with dzap buffers, and a command
   <code>MOVEBOX</code> to open it. It's opened automatically when you click
   on one of the &quot;Read...&quot; icons in the dzap box.

  <li>
   Adjusted the self-modifying code in a disk-reading subroutine so that it
   works on StrongARMs.

  <li>
   <em>Taskwindow</em> program extensively modified and improved.

  <li>
   Input focus change problem fixed.

  <li>
   RETURN shortcut implemented in Quit box.

  <li>
   More keypress changes:
   <table border=0>
    <tr>
     <td><strong>Key</strong>
     <td><strong>Where</strong>
     <td><strong>Function</strong>
    <tr valign=top>
     <td>Ctrl&nbsp;P
     <td>Search dbox, S&amp;R dbox
     <td>
      Paste the selection to the caret, translating control codes according
      to the '\ commands' option; pasting will stop after a \n unless the
      'raw' option is set. Macros are ignored.
    <tr valign=top>
     <td>Ctrl&nbsp;P
     <td>Minibuffer
     <td>
      Paste the selection to the caret, replacing control codes with spaces.
    <tr valign=top>
     <td>Ctrl&nbsp;W
     <td>Minibuffer
     <td>Paste the minibuffer contents to the editing window's cursor.
    <tr valign=top>
     <!-- was NOWRAP=OFF=1 in Shift Copy and Ctrl Copy -->
     <td>Shift&nbsp;Copy
     <td>Minibuffer
     <td>Delete word to right.
    <tr valign=top>
     <td>Ctrl&nbsp;Copy
     <td>Minibuffer.
     <td>Delete to end.
    <tr valign=top>
     <td>Ctrl&nbsp;K
     <td>Goto dbox, minibuffer
     <td>Clear history.
   </table>
   <br>
   (Minibuffer command codes 16, 14 and 23 correspond to <em>ctrl-P</em>,
   <em>ctrl-N</em> and <em>ctrl-W</em>.)

  <li>
   Search and replace:
   <ul compact>
    <li>new special character <code>\?</code>, representing DEL (chr code
    &amp;7F).
   <li>
    <code>\[...]</code> construct fixed:
    <ul compact>
     <li>
      Now allows ] to be included as a literal at the start of the string,
      eg. <code>\[][]</code> (find '[' or ']') or <code>\[^][]</code> (find
      anything except '[' and ']'). Search strings such as
      <code>\[[x]y]</code> are not affected by this change.
     <li>
      Ranges may now be specified in reverse order, eg. <code>Z-A</code>.
    </ul>
   </ul>

  <li>
   The search code can now check for a string starting at the given offset;
   to use this, set R4 (search direction) to 0. Also, setting b21 of R5
   causes the search code to set R3 to the cursor/point offset and R4 to 0
   (useful for conditional commands).

  <li>
   Hourglass percentage for 'all files' search/replace now uses the sum of
   the file lengths.

  <li>
   'Possibly modified' status for large files which are of their original
   length and marked as modified. This will be resolved on various actions
   which require to know whether the files are actually modified.

  <li>
   Fixed &quot;move down unnecessarily&quot; redraw bug (eg.
   <kbd>x\ny\n\nz\n\n\n</kbd>, first five lines selected,
   <code>INDENT</code>).

  <li>
   Commands accepting string parameters are now allowed to force the string
   to be supplied with the command; omitting the string for such commands
   (which would normally cause the minibuffer to be opened) will cause an
   error.

  <li>
   <em>Zap</em> now offers the option to try to stay up when an exception
   occurs. There may be occasions when <em>Zap</em> objects to this happening
   and will need to be restarted. Users are advised to attempt to preserve
   anything they have unsaved when this happens.
   <br>
   Zap will dump the registers for later retrieval via <em>*ShowRegs</em>.

  <li>
   New file naming fixed for unnamed types: <samp>&quot;xxx_n&quot;</samp>
   instead of <samp>&quot;&amp;xxxn&quot;</samp>.

  <li>
   Exception-handling code now tries to write &lt;Zap$Dir&gt;.ZapDump on a
   number of low level errors if a &lt;Zap$Dir&gt;.Debug file is present.

  <li>
   Horizontal scrollbar removal implemented (MISCOPS 18). There are two
   situations in which the scrollbar will be missing:
   <ul compact>
    <li>
     <strong>Window wrap=off</strong>. This works with any
     <em>WindowManager</em>; if it's recent enough, the extended
     <em>Wimp_OpenWindow</em> is used, else the window is deleted and
     recreated.
    <li>
     <strong>Full-width window</strong>. This works with
     <em>WindowManager</em> &gt;=3.80 (the "Nested Wimp") to avoid the
     possibly excessive redraws which would occur due to having to delete and
     recreate the window. (It uses the extended <em>Wimp_OpenWindow</em>.)
   </ul>

  <li>
   <code>BASEMAP</code> per window and as a default per mode.
   <br>
   From the extension author's POV, this means that <em>Zap</em> variables 13
   (key_basemap) and 23 (key_current) are now in the window block as
   w_basemap and w_currentmap. <em>Zap_ReadVar</em> and <em>Zap_WriteVar</em>
   will access these via R8; if R8=0 then attempts to read will return
   key_default and attempts to write will quietly fail.  The per-mode default
   is stored in the low byte of mode data variable 2, and as such, will be
   stored in &lt;Zap$Config&gt;.
   <br>
   Calling <em>Zap_ReadVar</em> for <em>key_default</em> will return
   <em>w_defaultmap</em> if R8<>0. Similarly, <em>Zap_WriteVar</em> will
   write to <em>w_defaultmap</em>.

  <li>
   In an editing window, <code>DEFAULTMAP</code> will reselect the default
   keymap for the mode in use in that window. Otherwise, it will select the
   global default keymap (as defined in the Keys file, variable number
   &amp;400) as the default for the default mode. In either case, if the
   keymap doesn't exist, it'll fall back on keymap 0.</LI>

  <li>
   When selecting a mode, if its configured basemap doesn't exist,
   <em>Zap</em> will fall back on the global default keymap then on keymap 0.

  <li>
   Keymap naming implemented; new commands <code>BASEMAPN</code> and
   <code>KEYMAPN</code>.
   <br>
   Names may currently be anything except &quot;&quot;; given a declaration<br>
   <kbd>&amp;401 &amp;000 &amp;1FF wibble</kbd><br>
   then keymap 1 will be named &quot;wibble&quot; and may be selected as the
   basemap via <code>BASEMAPN &quot;wibble&quot;</code> (exactly equivalent
   to <code>BASEMAP 1</code>).
   <br>
   Names are matched case insensitively. Two keymaps with the same name is
   silly; the first declared will be found.

  <li>
   Keymap 0 is called &quot;Default&quot;.</LI>

  <li>
   The <code>EMACS</code> command expects to find a keymap named
   &quot;Emacs&quot;.

  <li>
   <code>BASEMAPLIST</code> added (builds a keymaps list menu for basemap
   selection).

  <li>
   <code>BASEMAPN</code> now tickable on menus (in addition to
   <code>BASEMAP</code> and the <code>BASEMAPLIST</code> menu entries).

  <li>
   The editing window click handler now distinguishes between mouse buttons;
   multiple clicks must be done using the same mouse button.

  <li>
   The <code>HELP</code> commands now tell you if no help text has been found.

  <li>
   <code>HelpKey</code> (and <code>Help</code>) now use the keymap selected
   by the most recent <code>KeyMap</code>, <code>BaseMap</code>,
   <code>Emacs</code> etc. thus more easily allowing for help for keys in
   maps other than the current base map. If accessed via a keypress,
   <code>HelpKey/Help</code> must be present in that keymap.
   <br>
   A second <code>HelpKey</code> will, without first selecting a different
   keymap, use the base map.</LI>

  <li>
   Careful optimisation of all Zap's string handling routines for maximum speed.

  <li>
   Changes to the replacement <em>Debugger</em> to allow faster and better
   support from within <em>Zap</em> for syntax-colouring of assembler
   conditions.

  <li>
   Menu handling altered such that including an extension command in menus
   will not cause the extension module containing that command to be loaded
   unless the command has to be called when the menu is opened, updated or
   clicked on.

  <li>
   Hourglass activity added around file load/save operations.

  <li>
   Clicking Select or Adjust on certain dialogue box backgrounds will give
   them the input focus.

  <li>
   Adjust-click fixed for the case where the input focus is in a different
   <em>Zap</em> editing window.

  <li>
   Code mode branch-following now correctly sets the disassembler flags.

  <li>
   <em>Zap_UpdateWholeWindow</em> now calls <code>UPDATEWINDOW</code>.

  <li>
   Calls to <em>Zap_UpdateArea</em> and <em>Zap_UpdateWindow</em>
   generate 'deprecated' warnings.

  <li>
   Save box for untyped file now opens with Load/Exec writable.

  <li>
   Save boxes' <em>TAB</em> bug fixed.

  <li>
   <code>DELETENEXT</code> no longer checks Shift, always copying if the copy
   cursor is active. If you want the delete behaviour regardless, use
   <code>DELETENEXTNOCOPY</code> instead.

  <li>
   New command <code>PASSTHROUGH</code>. Use in TaskWindow mode to override
   Zap's claiming of certain keys/commands.

  <li>
   New function <code>@COPY</code>, indicating whether the copy cursor is
   active.

  <li>
   If you have both <em>LineEditor</em> and <em>Zap</em> set up such that
   <code>DELETENEXT</code> is bound to Copy, then changing the <em>Zap</em>
   key definition to<br>
   <code>IF (@MODET=3 AND @COPY=0):PASSTHROUGH
   &amp;18B:ELSE:DELETENEXT:ENDIF</code><br>
   will allow Copy to work in a taskwindow exactly as it does in any other
   window or at the (F12) command prompt.

  <li>
   Mode entry point e_return modified: on entry, R0=0 if <code>RETURN</code>,
   1 if <code>RETURNNOINDENT</code>. Code mode has been suitably modified so
   that RETURN maps to <code>ASSEMBLE</code> and <code>RETURNNOINDENT</code>
   to <code>EDITWORD</code>.</LI>

  <li>
   <em>Zap_Warning</em> modification: R1 bit 30 set to suppress the
   <samp>Warning:</samp> prefix.

  <li>
   Zap_ReturnWord allows \ddd, \xnn, \&amp;nn (search-like).

  <li>
   Zap_ProcessKeyCommand now relies on the parameter type passed in R2 b24-27
   (it used to rely on the type given in the command's flag word). Ensure
   that you're setting R2 up correctly...

  <li>
   Zap_ReadValidateCommand always returns R1=0 or R1-&gt;heap block. It is up
   to the calling code to free this block even if this call has returned an
   error.

  <li>
   All of the conditional commands, various functions and
   <code>MULTICOMMAND</code> (in practice, <code>COMMAND</code> or a command
   sequence) will work from places such as the iconbar menu.

  <li>
   Clipboard paste bug fixed (transfer via scrap file, Shift held down); the
   file contents will be inserted.

  <li>
   New cursor variable c_charoff. This is used to maintain offsets within
   tokens; it (mostly) fixes the situation in <em>BASIC</em> mode where the
   copy cursor is in a token below or to the right of the input cursor).
   <ul compact>
    <li><em>Zap_UpdateCaret</em> sets <em>c_charoff</em> to 0.
    <li><em>Zap_SetCaret</em> calculates a value for <em>c_charoff</em>.
    <li><em>Zap_AlterCaret</em> uses <em>c_charoff</em>.
   </ul>

  <li>
   Cursor scrolling misalignments fixed (bottom row of pixels of last
   displayed row not scrolled into view; left margin ignored).

 </ol>

<hr>

<?php
  zap_changelog_links ('ds');
  zap_body_end ('$Date: 2002/01/23 20:27:04 $');
?>
